<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\SeriesType;
use App\Repository\CommentsRepository;
use App\Repository\EpisodesRepository;
use App\Repository\SeriesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/series")
 */
class SeriesController extends AbstractController
{
    /**
     * @Route("/", name="series_index", methods={"GET"})
     */
    public function index(SeriesRepository $seriesRepository): Response
    {
        return $this->render('series/index.html.twig', [
            'series' => $seriesRepository->findAll()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="This page is only for administrators!")
     *
     * @Route("/new", name="series_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $series = new Series();
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['url']->getData();

            $file = $form['avatar']->getData();

            if($file !== null && $file instanceof UploadedFile) {

                $fileInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                try {
                    $fileName = \uniqid().\urldecode($fileInfo).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('series_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                    $this->addFlash('danger', 'Error on FileUpload : '.$e->getMessage());

                    return $this->redirectToRoute('series_index');
                }
                $series->setUrl($fileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($series);
            $entityManager->flush();

            return $this->redirectToRoute('series_index');
        }

        return $this->render('series/new.html.twig', [
            'series' => $series,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{order}", name="series_show", methods={"GET"})
     */
    public function show(Series $series, CommentsRepository $commentsRepository, EpisodesRepository $episodesRepository,
        $order = null): Response
    {
        $comments = $commentsRepository->findAllCommentsBySerie($series,$order);

        return $this->render('series/show.html.twig', [
            'episodes' => $episodesRepository->findAllEpisodesBySeries($series,null),
            'comments' => $comments,
            'series' => $series,
            'average_positive' => $commentsRepository->averageValidatedCommentsBySerie($series)
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="This page is only for administrators!")
     *
     * @Route("/{id}/edit", name="series_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Series $series): Response
    {
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('series_index');
        }

        return $this->render('series/edit.html.twig', [
            'series' => $series,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @IsGranted("ROLE_ADMIN", message="This page is only for administrators!")
     *
     * @Route("/{id}", name="series_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Series $series): Response
    {
        if ($this->isCsrfTokenValid('delete'.$series->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($series);
            $entityManager->flush();
        }

        return $this->redirectToRoute('series_index');
    }
}
