<?php

namespace App\Controller;

use App\Entity\Episodes;
use App\Form\EpisodesType;
use App\Repository\EpisodesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/episodes")
 */
class EpisodesController extends AbstractController
{
    /**
     * @Route("/", name="episodes_index", methods={"GET"})
     */
    public function index(EpisodesRepository $episodesRepository): Response
    {
        return $this->render('episodes/index.html.twig', [
            'episodes' => $episodesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="episodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $episode = new Episodes();
        $form = $this->createForm(EpisodesType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($episode);
            $entityManager->flush();

            return $this->redirectToRoute('episodes_index');
        }

        return $this->render('episodes/new.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="episodes_show", methods={"GET"})
     */
    public function show(Episodes $episode): Response
    {
        return $this->render('episodes/show.html.twig', [
            'episode' => $episode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="episodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Episodes $episode): Response
    {
        $form = $this->createForm(EpisodesType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('episodes_index');
        }

        return $this->render('episodes/edit.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="episodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Episodes $episode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('episodes_index');
    }
}
