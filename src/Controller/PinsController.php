<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    
    /**
     * @Route("/", name="app_pins")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Pin::class);

        $pins = $repo->findAll();

        return $this->render('pins/index.html.twig', [
            'name' => 'Jean Lionel Le hacker',
            'pins' => $pins,
        ]);
    }

    /**
     * @Route("/pins/create", methods={"GET", "POST"})
     */

    public function create(Request $request, EntityManagerInterface $em)
    {
        if ($request->isMethod('POST')) {
            // code...
           $data = $request->request->all();

           $pin = new Pin();

           $pin->setTitle($data['title']);
           $pin->setDescription($data['description']);
           $repo = $em->getRepository(Pin::class);
           $repo->add($pin, true);

           return $this->redirect('/');

        }
        return $this->render('pins/create.html.twig');
    }
}
