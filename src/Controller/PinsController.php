<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $repo): Response
    {
       
        return $this->render('pins/index.html.twig', [
            'pins' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/pins/create", methods={"GET", "POST"})
     */

    public function create(Request $request, PinRepository $repo): Response
    {
        $pin = new Pin();
      $form = $this->createFormBuilder($pin)
                    ->add('title', null)
                    ->add('description', null,[
                        "attr" => [
                            "rows" => 5,
                            "cols" => 15
                        ]
                    ])
                    ->getForm()
                ;

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $repo->add($pin, true);

        return $this->redirectToRoute("app_home");
      }


        return $this->render('pins/create.html.twig',[
            'form' =>  $form->createView()
        ]);
    }
}
