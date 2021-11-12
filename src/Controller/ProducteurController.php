<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Producteur;
use App\Form\ProducteurType;
use App\Repository\BeerRepository;
use App\Repository\ProducteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producteur")
 */
class ProducteurController extends AbstractController
{
    /**
     * @Route("/", name="producteur_index", methods={"GET"})
     */
    public function index(ProducteurRepository $producteurRepository): Response
    {
        return $this->render('producteur/index.html.twig', [
            'producteurs' => $producteurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="producteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producteur = new Producteur();
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producteur);
            $entityManager->flush();

            return $this->redirectToRoute('producteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producteur/new.html.twig', [
            'producteur' => $producteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="producteur_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $producteur = $this->getDoctrine()
            ->getRepository(Producteur::class)
            ->find($id);
        if (!$producteur) {
            throw $this->createNotFoundException(
                'No produteur found for id '.$id
            );
        }
        return $this->render('producteur/show.html.twig', [
            'producteur' => $producteur
        ]);

    }


    /**
     * @Route("/{id}/edit", name="producteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producteur $producteur): Response
    {
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producteur/edit.html.twig', [
            'producteur' => $producteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="producteur_delete", methods={"POST"})
     */
    public function delete(Request $request, Producteur $producteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
