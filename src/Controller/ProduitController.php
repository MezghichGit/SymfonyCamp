<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/produits')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index')]
   public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();

        // dd($produits);
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    } 


    #[Route('/add', name: 'add')]
    public function createProduit(Request $request, ValidatorInterface $validator, ProduitRepository $produitRepository): Response
    {
        if($request->getMethod()=="POST") {
            $product = new Produit();

            $product->setLibelle($request->get("libelle"));
            $product->setPrix($request->get("prix"));

            //$errors = $validator->validate($product);
            /*if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }*/

            $product->setDescription($request->get("description"));
            $product->setPhoto("image.png");
            $produitRepository->save($product, true);

            //return new Response('Saved new product with id '.$product->getId());
            return $this->redirectToRoute('app_produit_index');
        } else {
            return $this->render('produit/add.html.twig');
        }
    }

    #[Route('/show/{id}', name: 'show_produit')]
    //public function show_produit($id,ManagerRegistry $doctrine)
    public function show_produit($id, ProduitRepository $produitRepository)
    {
        // $entityManager = $doctrine->getManager(); // récupération de Doctrine
        // $produit = $entityManager->getRepository(Produit::class)->find($id);
        $produit = $produitRepository->find($id);
        if (!$produit) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
        //return new Response('Check out this great product: '.$produit->getLibelle());

    }


    #[Route('/delete/{id}', name: 'delete_produit')]
    public function delete_produit($id, ProduitRepository $produitRepository)
    {

        $produit = $produitRepository->find($id);
        if (!$produit) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $produitRepository->remove($produit, true);
        return $this->redirectToRoute('app_produit_index');

    }

    #[Route('/editer/{id}', name: 'edit_produit')]
    public function edit_produit(Request $request, $id, ProduitRepository $produitRepository)
    {

        $produit = $produitRepository->find($id);
        if (!$produit) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        if($request->getMethod()=="POST") {

            $produit->setLibelle($request->get("libelle"));
            $produit->setPrix($request->get("prix"));

            $produit->setDescription($request->get("description"));
            $produit->setPhoto("image.png");
            $produitRepository->save($produit, true);

            //return new Response('Saved new product with id '.$product->getId());
            return $this->redirectToRoute('app_produit_index');
        } else {
            //dd($produit->getLibelle());
            return $this->render('produit/edit.html.twig', [
                'produit'=>$produit
            ]);
        }



    }

}
