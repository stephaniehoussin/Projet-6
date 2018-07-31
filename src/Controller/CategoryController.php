<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("add-category", name="add-category")
     */
    public function addCategory()
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $category->setName('Spot Parc');
        $em->persist($category);
        $category1 = new Category();
        $category1->setName('Spot Au bord de l\'eau');
        $em->persist($category1);
        $category2 = new Category();
        $category2->setName('Spot Terrasse Restaurant');
        $em->persist($category2);
        $category3 = new Category();
        $category3->setName('Spot Terrasse Café');
        $em->persist($category3);
        $category4 = new Category();
        $category4->setName('Spot Foret');
        $em->persist($category4);
        $em->flush();
        return $this->render('category/test.html.twig');
    }

    /**
     * @Route("show-category", name="show-category")
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig',array(
            'categories' => $categories
        ));
    }
}
