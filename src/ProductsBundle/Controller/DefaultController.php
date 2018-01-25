<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\Bidding;
use ProductsBundle\Entity\history_bidding;
use ProductsBundle\Entity\Rates;
use ProductsBundle\Form\BiddingType;
use ProductsBundle\Form\history_biddingType;
use ProductsBundle\Form\RatesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('ProductsBundle:Category');

        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findBy(array('parent' => null));
        ;

        $products = $em
        ->getRepository('ProductsBundle:Product')
        ->findAll();


        return $this->render('default/index.html.twig', [
            'parentCategories' => $categories,
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}"), name="single-product")
     *
     */
    public function singleAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('ProductsBundle:Category');

        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findBy(array('parent' => null));
        ;

        $product = $em
            ->getRepository('ProductsBundle:Product')
            ->find($id);

        $rate = new Rates();
        $form = $this->get('form.factory')->create(RatesType::class, $rate);

        $rates = $em
            ->getRepository('ProductsBundle:Rates')
            ->findBy(array('Product' => $id));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($this->getUser() != $product->getUser()) {
                $rate->setUser($this->getUser());
                $rate->setProduct($product);
                $em = $this->getDoctrine()->getManager();
                $em->persist($rate);
                $em->flush();
                $request->getSession()->getFlashBag()->add('sucess', 'Le commentaire à bien été ajouté');
                return $this->redirectToRoute('products_default_single', array('id' => $id));
            }else{
                $request->getSession()->getFlashBag()->add('danger', 'Vous ne pouvez pas commenter vos propres produits.');
                return $this->redirectToRoute('products_default_single', array('id' => $id));
            }
        }

        return $this->render('default/product/single-product.html.twig', [
            'parentCategories' => $categories,
            'product' => $product,
            'rates' => $rates,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/{id}"), name="categories-product")
     *
     */
    public function categoriesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('ProductsBundle:Product');

        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findBy(array('parent' => null));
        ;


        $query = $repository->createQueryBuilder('u')
            ->innerJoin('u.categories', 'g')
            ->where('g.id = :category_id')
            ->setParameter('category_id', $id)
            ->getQuery()->getResult();

        return $this->render('default/index.html.twig', [
            'parentCategories' => $categories,
            'products' => $query,
        ]);
    }


    /**
     * @Route("/bidding/{id}"), name="bidding")
     *
     */
    public function bindAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findBy(array('parent' => null));

        $product = $em
            ->getRepository('ProductsBundle:Product')
            ->find($id);

        $bidding = new history_bidding();
        $form = $this->get('form.factory')->create(history_biddingType::class, $bidding);

        $history =  $em
            ->getRepository('ProductsBundle:history_bidding')
            ->findBy(array('product' => $product->getId()));
        $history = array_reverse($history);

        $form->handleRequest($request);

        $minBid = $em
            ->getRepository('ProductsBundle:history_bidding')
            ->getlastBid($id);

        if ($minBid == null)
            $minBid = $product->getStartingPrice();
        else{
            $minBid = $minBid["bid"];
        }
        $minBid = $minBid + $product->getMinBid();
        if ($form->isSubmitted() && $form->isValid()) {
            $biddingManager = $this->get('bidding_manager');
            $biddingManager->setForm($form)->createForm();
            if( $form->get('bid')->getData() < $minBid ){
                $request->getSession()->getFlashBag()->add('alert', "Une erreur s'est produite  Votre enchère est trop petite. L'enchère doit être au minimum de  $minBid  € .");
            }else{
                $bidding->setUser($this->getUser());
                $bidding->setProduct($product);
                $em->persist($bidding);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Votre enchère à bien été pris en compte');
            }
           //return $this->redirectToRoute('products_default_bind', array('id' => $id));
        }
        return $this->render('default/bidding/index.html.twig', [
            'parentCategories' => $categories,
            'product'          => $product,
            'form'             => $form->createView(),
            'history'          => $history
        ]);
    }
}
