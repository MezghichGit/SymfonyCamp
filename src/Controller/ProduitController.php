<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index')]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }


    #[Route('/add', name: 'add')]
    public function createProduit(ProduitRepository $produitRepository): Response
    {
  
        $product = new Produit();
        $product->setLibelle('iPhone 14');
        $product->setPrix(4000);
        $product->setDescription('un smart phone tout neuf!');
        $product->setPhoto("iphone14.png");
        $produitRepository->save($product,true);

        return new Response('Saved new product with id '.$product->getId());
    }

}
