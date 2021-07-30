<?php

namespace App\Controller;

use App\Entity\Podcast;
use App\Entity\Reaction;
use App\Form\PodcastType;
use App\Repository\PodcastRepository;
use App\Repository\ReactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/podcast")
 */
class PodcastController extends AbstractController
{
    /**
     * @Route("/", name="podcast_index", methods={"GET"})
     */
    public function index(PodcastRepository $podcastRepository): Response
    {
        return $this->render('podcast/index.html.twig', [
            'podcasts' => $podcastRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="podcast_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $podcast = new Podcast();
        $form = $this->createForm(PodcastType::class, $podcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($podcast);
            $entityManager->flush();

            return $this->redirectToRoute('podcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('podcast/new.html.twig', [
            'podcast' => $podcast,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="podcast_show", methods={"GET"})
     */
    public function show(Podcast $podcast, ReactionRepository $reactionRepository): Response
    {
        $reactions = $reactionRepository->findBy(['podcastId'=>$podcast]);
        return $this->render('podcast/show.html.twig', [
            'podcast' => $podcast,
            'reactions' => $reactions
        ]);
    }

    /**
     * @Route("/{id}/edit", name="podcast_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Podcast $podcast): Response
    {
        $form = $this->createForm(PodcastType::class, $podcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('podcast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('podcast/edit.html.twig', [
            'podcast' => $podcast,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="podcast_delete", methods={"POST"})
     */
    public function delete(Request $request, Podcast $podcast): Response
    {
        if ($this->isCsrfTokenValid('delete'.$podcast->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($podcast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('podcast_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/happy", name="reaction_happy")
     */
    public function happy(Request $request, ReactionRepository $reactionRepository, Podcast $podcast, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(1);
        $reaction = new Reaction();
        $reaction->setType('content');
        $reaction->setUserId($user);
        $reaction->setPodcastid($podcast);
        $reaction->setPicture("img/happy.png");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reaction);
        $entityManager->flush();
        return $this->redirectToRoute('podcast_show', ['id'=>$podcast->getId()]);
    }

    /**
     * @Route("/{id}/confused", name="reaction_confused")
     */
    public function confused(Request $request, ReactionRepository $reactionRepository, Podcast $podcast, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(1);
        $reaction = new Reaction();
        $reaction->setType('perplexe');
        $reaction->setUserId($user);
        $reaction->setPodcastid($podcast);
        $reaction->setPicture("img/confused.png");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reaction);
        $entityManager->flush();
        return $this->redirectToRoute('podcast_show', ['id'=>$podcast->getId()]);
    }
    
    /**
     * @Route("/{id}/unsure", name="reaction_unsure")
     */
    public function unsure(Request $request, ReactionRepository $reactionRepository, Podcast $podcast, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(1);
        $reaction = new Reaction();
        $reaction->setType('bof');
        $reaction->setUserId($user);
        $reaction->setPodcastid($podcast);
        $reaction->setPicture("img/unsure.png");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reaction);
        $entityManager->flush();
        return $this->redirectToRoute('podcast_show', ['id'=>$podcast->getId()]);
    }

    /**
     * @Route("/{id}/sad", name="reaction_sad")
     */
    public function sad(Request $request, ReactionRepository $reactionRepository, Podcast $podcast, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(1);
        $reaction = new Reaction();
        $reaction->setType('pas content');
        $reaction->setUserId($user);
        $reaction->setPodcastid($podcast);
        $reaction->setPicture("img/sad.png");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reaction);
        $entityManager->flush();
        return $this->redirectToRoute('podcast_show', ['id'=>$podcast->getId()]);
    }
}
