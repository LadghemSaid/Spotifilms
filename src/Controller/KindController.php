<?php

namespace App\Controller;

use App\Entity\Kind;
use App\Form\KindType;
use App\Repository\KindRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kind")
 */
class KindController extends AbstractController
{
    /**
     * @Route("/", name="kind_index", methods={"GET"})
     */
    public function index(KindRepository $kindRepository): Response
    {
        return $this->render('kind/index.html.twig', [
            'kinds' => $kindRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="kind_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $kind = new Kind();
        $form = $this->createForm(KindType::class, $kind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kind);
            $entityManager->flush();

            return $this->redirectToRoute('kind_index');
        }

        return $this->render('kind/new.html.twig', [
            'kind' => $kind,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kind_show", methods={"GET"})
     */
    public function show(Kind $kind): Response
    {
        return $this->render('kind/show.html.twig', [
            'kind' => $kind,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="kind_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Kind $kind): Response
    {
        $form = $this->createForm(KindType::class, $kind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kind_index');
        }

        return $this->render('kind/edit.html.twig', [
            'kind' => $kind,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kind_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Kind $kind): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kind->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kind);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kind_index');
    }
}
