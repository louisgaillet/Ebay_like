<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\Bidding;
use ProductsBundle\Entity\Rates;
use ProductsBundle\Form\BiddingType;
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
        $repository = $this->getDoctrine()->getRepository('ProductsBundle:Bidding');

        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findBy(array('parent' => null));
        ;

        $product = $em
            ->getRepository('ProductsBundle:Product')
            ->find($id);

        $actualBidding = $repository->find($product->getBindding());

        $bidding = new Bidding();
        $form = $this->get('form.factory')->create(BiddingType::class, $bidding);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bidding);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Product has been created.');
        }

        return $this->render('default/bidding/index.html.twig', [
            'parentCategories' => $categories,
            'product'          => $product,
            'bidding'             => $actualBidding,
            'form'             => $form->createView()
        ]);
    }
}
