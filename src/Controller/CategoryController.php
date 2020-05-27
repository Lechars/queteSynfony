<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

Class CategoryController extends AbstractController
{
    /**
     * @Route("/category/add", name="add_category")
     * @param $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category= new Category();
        $form=$this->createForm(CategoryType::class,$category,
            ['method' => Request::METHOD_GET]
        );
        $form->handleRequest($request);

        return $this->render(
            'wild/form.html.twig',['form'=>$form->createView()]);
    }
}