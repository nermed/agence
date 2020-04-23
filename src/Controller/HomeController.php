<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
//use Doctrine\ORM\EntityManager;
//use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @param PropertyRepository $repository
     * 
     * @return void
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("/", name="/")
     */
    public function index() : Response
    {
        //$properties = new Property();
        $properties = $this->repository->findLatest();
        
        //$repository = $this->getDoctrine()->getRepository(Property::class);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties
        ]);
    }
}