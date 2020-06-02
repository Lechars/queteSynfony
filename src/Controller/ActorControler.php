<?php

namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\ActorRepository;
use App\Entity\Actor;

/**
 * Class ActorControler
 * @package App\Controller
 * @Route("/actor")
 */

class ActorControler extends AbstractController
{
    /**
     * @Route ("/{id}",name="actor_select",defaults={"id"="pageVide"})
     */

    public function ActorById($id)
    {
        if ($id == "pageVide") {
            return $this->render('wild/showActor.html.twig', ['acteur' => "Aucun acteur sélectionné, veuillez choisir un acteur"]);
        } else {
            $acteur=$this->getDoctrine()
                ->getRepository(Actor::class)
                ->findOneBy(['id'=>$id]);

            return $this->render('wild/showActor.html.twig',['acteur'=>$acteur]);
        }
    }
}