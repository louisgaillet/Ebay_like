<?php

namespace ProductsBundle\Controller;

use AppBundle\Form\UserType;
use ProductsBundle\Entity\Category;
use ProductsBundle\Entity\Product;
use ProductsBundle\Entity\Bidding;
use AppBundle\Entity\User;
use ProductsBundle\Form\CategoryType;
use ProductsBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/dashboard")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig', [
            'test' => 'Dasboard',
        ]);
    }

    /**
     * @Route("/products/", name="dab-add-product")
     */
    public function addAction(Request $request)
    {

        $product = new Product();
        $form = $this->get('form.factory')->create(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bindding = new Bidding();
            $product->setUser($this->getUser());
            $product->setBindding($bindding);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Product has been created.');
            return $this->redirectToRoute('dab-list-products');
        }

        return $this->render('admin/products/new.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dashboard/products/list", name="dab-list-products")
     */

    public function listProducts()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $products = $em
            ->getRepository('ProductsBundle:Product')
            ->findBy(array('User' => $user->getId()));
        ;


        return $this->render('admin/products/list-products.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("dashboard/product/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */

    public function editAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repository = $doctrine->getRepository('ProductsBundle:Product');

        $product = $repository->find($id);

        $editForm = $this->createForm('ProductsBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('admin/products/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
        ));
    }



    /**
     * @Route("/dashboard/products/remove/{id}", name="dab-remove-product")
     */

    public function removeAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repository = $doctrine->getRepository('ProductsBundle:Product');

        $product = $repository->find($id);
        $em->remove($product);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Product has been deleted.');

        return $this->redirectToRoute('dab-list-products');
    }

    /**
     * @Route("/dashboard/category", name="dab-add-category")
     */
    public function categoryAction(Request $request){

        $category = new Category();
        $form = $this->get('form.factory')->create(CategoryType::class, $category);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $parent_id =$form->get('categories')->getData()->get('0');
            $category->setParent($parent_id);
            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Category has been created.');
        }


        return $this->render('admin/categories/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/dashboard/category/list", name="dab-list-categories")
     */

    public function listCategories()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em
            ->getRepository('ProductsBundle:Category')
            ->findAll()
        ;


        return $this->render('admin/list-categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/dashboard/categories/remove/{id}", name="dab-remove-category")
     */

    public function removeCategorie(Request $request, $id)
    {

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repository = $doctrine->getRepository('ProductsBundle:Category');

        $category = $repository->find($id);
        $em->remove($category);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Category has been deleted.');

        return $this->redirectToRoute('dab-list-categories');
    }


    /**
     * @Route("/dashboard/profil")
     */
    public function profilAction()
    {

        $user = new User();
        //
    }


}
