<?php

namespace FireDIY\PrivateMessageBundle\Controller;

use FireDIY\PrivateMessageBundle\Entity\Conversation;
use FireDIY\PrivateMessageBundle\Entity\PrivateMessage;
use FireDIY\PrivateMessageBundle\Form\ConversationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ConversationController
 * @package FireDIY\PrivateMessageBundle\Controller
 * @Security("has_role('ROLE_USER')")
 */
class ConversationController extends Controller
{
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

        // TODO: add custom validation to prevent sending a message to oneself.
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();

            $this
                ->get('session')
                ->getFlashBag()
                ->add('success', $this->get('translator')->trans('Conversation created'));

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('FDPrivateMessageBundle:Conversation:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Initialize a new conversation with current user as author.
     *
     * @return \FireDIY\PrivateMessageBundle\Entity\Conversation
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
