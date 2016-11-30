<?php

namespace FD\PrivateMessageBundle\Controller;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Entity\PrivateMessage;
use FD\PrivateMessageBundle\Form\ConversationType;
use FD\PrivateMessageBundle\Form\PrivateMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ConversationController
 * @package FD\PrivateMessageBundle\Controller
 * @Security("has_role('ROLE_USER')")
 */
class ConversationController extends Controller
{
    /**
     * Display a conversation.
     * TODO: maybe use a slug instead of conversation's id.
     *
     * @param Conversation $conversation : instance of the conversation
     * @param Request      $request      : instance of the current request.
     * @return mixed
     */
    public function showAction(Conversation $conversation, Request $request)
    {
        // A user MUST be a recipient/author of the conversation to see it.
        if ($conversation->getAuthor() != $this->getUser() && !in_array($this->getUser(), $conversation->getRecipients()->toArray())) {
            throw $this->createAccessDeniedException('You are not allowed to access this content');
        }

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
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $conversation = $this->buildConversation();

        $form = $this->createForm(ConversationType::class, $conversation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();

            $this
                ->get('session')
                ->getFlashBag()
                ->add('success', $this->get('translator')->trans('Conversation created'));

            // TODO: dispatch event.

            return $this->redirect($this->generateUrl('fdpm_list_conversations'));
        }

        return $this->render('FDPrivateMessageBundle:Conversation:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Initialize a new conversation with current user as author.
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
