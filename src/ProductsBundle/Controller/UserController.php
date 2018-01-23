<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\Rates;
use ProductsBundle\Entity\RatesUser;
use ProductsBundle\Form\productType;
use ProductsBundle\Form\RatesType;
use ProductsBundle\Form\RatesUserType;
use ProductsBundle\ProductsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use ProductsBundle\Entity\Product;
use ProductsBundle\Entity\Category;




class UserController extends Controller
{
    /**
     * @Route("/user/{id}"), name="user-page")
     */
    public function indexAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('ProductsBundle:Category');

        $products = $em
            ->getRepository('ProductsBundle:Product')
            ->findBy(array('User' => $id));
        ;

        $user = $em
            ->getRepository('AppBundle:User')
            ->find($id);

        $rates = $em
            ->getRepository('ProductsBundle:RatesUser')
            ->findBy(array('Owner' => $id));

        $rateUser = new RatesUser();
        $form = $this->get('form.factory')->create(RatesUserType::class, $rateUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser() != $user) {

                $rateUser->setOwner($user);
                $rateUser->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($rateUser);
                $em->flush();
                $request->getSession()->getFlashBag()->add('sucess', 'La note à bien été ajouté');

            } else {
                $request->getSession()->getFlashBag()->add('danger', 'Vous ne pouvez pas noter vos propres produits.');

            }
        }

        return $this->render('default/user/index.html.twig', [
            'user' => $user,
            'products' => $products,
            'form' => $form->createView(),
            'rates' => $rates
        ]);
    }


}
