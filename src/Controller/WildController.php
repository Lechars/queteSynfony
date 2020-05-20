<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/wild", name="wild_")
 */

Class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() : Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/show/{slug}",requirements={"slug"="([a-z0-9](-)?)+"}, defaults={"slug"="pageVide"}, name="show")
     */
    public function show(string $slug): Response
    {
        if ($slug == "pageVide") {
            return $this->render('wild/show.html.twig', ['metalSlug' => "Aucune série sélectionnée, veuillez choisir une série"]);
        } else {
            $slug = str_replace("-", " ", $slug);
            $slugTab = explode(" ", $slug);
            foreach ($slugTab as $key => $limace) {
                $slugTab[$key] = ucfirst($limace);
            }
            $slug = implode(" ", $slugTab);
            return $this->render('wild/show.html.twig', ['metalSlug' => $slug]);
        }
    }

    /**
     * @Route("/cat/{categoryName}", name ="cat")
     */

    public function showByCategory(string $categoryName): Response
    {
         $category = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findOneBy(['name'=>$categoryName]);
         $catTitle=$category->getId();

         $program=$this->getDoctrine()
             ->getRepository(Program::class)
             ->findBy(['category'=>$catTitle],['id'=>'desc'],3);


         return $this->render('wild/category.html.twig',["prog"=>$program]);
    }
}