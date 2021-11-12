<?php

namespace App\Controller;

use App\Entity\Bucket;
use App\Form\BucketType;
use App\Repository\BucketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bucket")
 */
class BucketController extends AbstractController
{
    /**
     * @Route("/", name="bucket_index", methods={"GET"})
     */
    public function index(BucketRepository $bucketRepository): Response
    {
        return $this->render('bucket/index.html.twig', [
            'buckets' => $bucketRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bucket_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bucket = new Bucket();
        $form = $this->createForm(BucketType::class, $bucket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bucket);
            $entityManager->flush();

            return $this->redirectToRoute('bucket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bucket/new.html.twig', [
            'bucket' => $bucket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bucket_show", methods={"GET"})
     */
    public function show(Bucket $bucket): Response
    {
        return $this->render('bucket/show.html.twig', [
            'bucket' => $bucket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bucket_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bucket $bucket): Response
    {
        $form = $this->createForm(BucketType::class, $bucket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bucket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bucket/edit.html.twig', [
            'bucket' => $bucket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bucket_delete", methods={"POST"})
     */
    public function delete(Request $request, Bucket $bucket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bucket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bucket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bucket_index', [], Response::HTTP_SEE_OTHER);
    }
}
