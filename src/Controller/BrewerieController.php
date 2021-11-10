<?php

namespace App\Controller;

use App\Entity\Brewerie;
use App\Form\BrewerieType;
use App\Repository\BrewerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/brewerie")
 */
class BrewerieController extends AbstractController
{
    /**
     * @Route("/", name="brewerie_index", methods={"GET"})
     */
    public function index(BrewerieRepository $brewerieRepository): Response
    {
        return $this->render('brewerie/index.html.twig', [
            'breweries' => $brewerieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="brewerie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $brewerie = new Brewerie();
        $form = $this->createForm(BrewerieType::class, $brewerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($brewerie);
            $entityManager->flush();

            return $this->redirectToRoute('brewerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('brewerie/new.html.twig', [
            'brewerie' => $brewerie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="brewerie_show", methods={"GET"})
     */
    public function show(Brewerie $brewerie): Response
    {
        return $this->render('brewerie/show.html.twig', [
            'brewerie' => $brewerie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="brewerie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Brewerie $brewerie): Response
    {
        $form = $this->createForm(BrewerieType::class, $brewerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('brewerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('brewerie/edit.html.twig', [
            'brewerie' => $brewerie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="brewerie_delete", methods={"POST"})
     */
    public function delete(Request $request, Brewerie $brewerie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewerie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brewerie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('brewerie_index', [], Response::HTTP_SEE_OTHER);
    }
}
