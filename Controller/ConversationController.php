<?php

namespace FD\PrivateMessageBundle\Controller;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Entity\PrivateMessage;
use FD\PrivateMessageBundle\Event\ConversationEvent;
use FD\PrivateMessageBundle\FDPrivateMessageEvents;
use FD\PrivateMessageBundle\Form\ConversationType;
use FD\PrivateMessageBundle\Form\PrivateMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ConversationController.
 *
 * @Security("has_role('ROLE_USER')")
 */
class ConversationController extends Controller
{
    /**
     * Display a conversation.
     * TODO: maybe use a slug instead of conversation's id.
     * @ParamConverter(name="conversation", class="FDPrivateMessageBundle:Conversation", options={
     *     "repository_method" = "getOneById",
     *     "map_method_signature" = true
     * })
     * @Security("is_granted('view', conversation)")
     *
     * @param Conversation $conversation : The conversation object.
     * @param Request      $request      : The current request object.
     *
     * @return mixed
     */
    public function showAction(Conversation $conversation, Request $request)
    {
        // Create the answer form.
        $privateMessage = new PrivateMessage();
        $privateMessage
            ->setConversation($conversation)
            ->setAuthor($this->getUser());

        $form = $this->createForm(PrivateMessageType::class, $privateMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($privateMessage);
            $em->flush();

            return $this->redirect($this->generateUrl('fdpm_show_conversation', ['conversation' => $conversation->getId()]));
        }

        // TODO: use pagination for conversation's messages.
        return $this->render('FDPrivateMessageBundle:Conversation:show.html.twig', array(
            'conversation' => $conversation,
            'form'         => $form->createView(),
        ));
    }

    /**
     * Display list of current user's conversation.
     *
     * @return Response
     */
    public function listAction()
    {
        // Get all conversations of current user. TODO: use pagination.
        $conversations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FDPrivateMessageBundle:Conversation')
            ->getAllByRecipient($this->getUser());

        return $this->render('FDPrivateMessageBundle:Conversation:list.html.twig', array(
            'conversations' => $conversations,
        ));
    }

    /**
     * Displays form for a new conversation and handle submission.
     *
     * @param Request $request : instance of the current request.
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $conversation = $this->buildConversation();

        $form = $this->createForm(ConversationType::class, $conversation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Add the current user as recipient anyway.
            $conversation->addRecipient($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('Conversation created'));

            /** @var EventDispatcherInterface $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $event = new ConversationEvent($conversation, $request, $this->getUser());
            $dispatcher->dispatch(FDPrivateMessageEvents::CONVERSATION_CREATED, $event);

            return $this->redirect($this->generateUrl('fdpm_list_conversations'));
        }

        return $this->render('FDPrivateMessageBundle:Conversation:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Make the current user leave the given conversation.
     *
     * TODO: perhaps use a submittable form to enforce user to confirm action.
     * @ParamConverter(name="conversation", class="FDPrivateMessageBundle:Conversation", options={
     *     "repository_method" = "getOneById",
     *     "map_method_signature" = true
     * })
     * @param Conversation $conversation : The conversation object.
     * @param Request      $request      : The current request object.
     *
     * @return RedirectResponse
     */
    public function leaveAction(Conversation $conversation, Request $request)
    {
        $conversation->removeRecipient($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($conversation);
        $em->flush();

        $this->addFlash('success', $this->get('translator')->trans('You have left the conversation'));

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->get('event_dispatcher');
        $event      = new ConversationEvent($conversation, $request, $this->getUser());
        $dispatcher->dispatch(FDPrivateMessageEvents::CONVERSATION_LEFT, $event);

        return $this->redirectToRoute('fdpm_list_conversations');
    }

    /**
     * Initialize a new conversation with current user as author.
     * TODO: deport in a builder service.
     *
     * @return \FD\PrivateMessageBundle\Entity\Conversation
     */
    protected function buildConversation()
    {
        $user = $this->getUser();
        $conversation = new Conversation();

        $message = new PrivateMessage();

        $message
            ->setAuthor($user)
            ->setConversation($conversation);

        $conversation
            ->setAuthor($user)
            ->setFirstMessage($message)
            ->setLastMessage($message);

        return $conversation;
    }
}
