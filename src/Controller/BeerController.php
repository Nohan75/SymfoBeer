<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Bucket;
use App\Entity\Client;
use App\Form\BeerType;
use App\Repository\BeerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/beer")
 */
class BeerController extends AbstractController
{
    /**
     * @Route("/", name="beer_index", methods={"GET"})
     */
    public function index(BeerRepository $beerRepository): Response
    {
        return $this->render('beer/index.html.twig', [
            'beers' => $beerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/all", name="beerview")
     */
    public function allBeer(BeerRepository $beerRepository): Response
    {
        return $this->render('beerview/index.html.twig', [
            'beers' => $beerRepository->findBeers(),
        ]);
    }

    /**
     * @Route("/addcart/{beer_id}", name="add_cart")
     * @return Response
     */
    public function buyBeer(string $beer_id, EntityManagerInterface $entityManager, BeerRepository $beerRepository): Response
    {
        $beer = $entityManager->getRepository(Beer::class)->findOneBeer($beer_id);
        $client = $entityManager->getRepository(Client::class)->findOneClient(1);
        $panier = new Bucket();
        $panier->addBeerId($beer)
            ->setClientId($client);
        $entityManager->persist($panier);
        $entityManager->flush();
        return $this->render('beerview/index.html.twig', [
            'beers' => $beerRepository->findBeers()
        ]);
    }

    /**
     * @Route("/new", name="beer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $beer = new Beer();
        $form = $this->createForm(BeerType::class, $beer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($beer);
            $entityManager->flush();

            return $this->redirectToRoute('beer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('beer/new.html.twig', [
            'beer' => $beer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="beer_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $beer = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->find($id);
        if (!$beer) {
            throw $this->createNotFoundException(
                'No beer found for id '.$id
            );
        }
        return $this->render('beer/show.html.twig', [
            'beer' => $beer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="beer_edit", methods={"GET","POST"})
     */
    public function edit(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
            throw $this->createNotFoundException(
                'No beer found for id ' . $id
            );
        }
        $entityManager->flush();
        return $this->redirectToRoute('beer_index', [], Response::HTTP_SEE_OTHER);


        return $this->renderForm('beer/edit.html.twig', [
            'beer' => $beer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="beer_delete", methods={"POST"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Client::class)->find($id);

        if (!$beer) {
            throw $this->createNotFoundException(
                'No beer found for id ' . $id
            );
        }
        $entityManager->flush();
        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);


        return $this->redirectToRoute('beer_index', [], Response::HTTP_SEE_OTHER);
    }
}
