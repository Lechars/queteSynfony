<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/wild", name="wild_")
 */

Class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        $form=$this->createForm(CategoryType::class,null,['method'=>Request::METHOD_GET]);


        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render(
            'wild/index.html.twig',
            ['programs' => $programs, 'form'=>$form->createView()]
        );

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

    /**
     * @Route("/wiki/{slug}", name ="wiki", defaults={"slug"="pageVide"})
     */

    public function showByProgram(string $slug): Response
    {
        if ($slug == "pageVide") {
            return $this->render('wild/progSaeson.html.twig', ['metalSlug' => "Aucune série sélectionnée, veuillez choisir une série"]);
        } else {
            $slug = str_replace("-", " ", $slug);
            $slugTab = explode(" ", $slug);
            foreach ($slugTab as $key => $limace) {
                $slugTab[$key] = ucfirst($limace);
            }

            $slug = implode(" ", $slugTab);
        }

        $prog=$this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=>$slug]);

        $progId=$prog->getId();

        $seasons=$this->getdoctrine()
            ->getRepository(Season::class)
            ->findby(['program'=>$progId]);

            return $this->render('wild/progSaeson.html.twig',['prog'=>$seasons]);
    }

    /**
     * @Route("/saison/{id}", name ="bySaison", defaults={"id"="pageVide"})
     */

    public function showBySeason(int $id): Response
    {
        $saison=$this->getdoctrine()
            ->getRepository(Season::class)
            ->find($id);

        return $this->render('wild/epiBySaes.html.twig',['saison'=>$saison]);
    }



    /**
     * @Route("/episode/{id}", name="byEpisode",defaults={"id"="pageVide"})
     */

    public function showEpisode(Episode $episode): Response
    {
        $saison=$episode->getSeason();
        return $this->render('wild/showEpisode.html.twig',['episode'=>$episode,'saison'=>$saison]);
    }
}