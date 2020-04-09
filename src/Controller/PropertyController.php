<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManager;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @param PropertyRepository $repository
     * @param EntityManager $em
     * 
     * @return void
     */
    public function __construct(PropertyRepository $repository)
    {
        return $this->repository= $repository;
                //$this->em = $em;
    }
    /**
     * @Route("/biens", name="properties")
     */
    public function index(): Response
    {
        $property = new Property();
        
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements= {"slug" : "[a-z0-9\-]*"})
     * @return Response
     * @param Property $property
     * @param string $slug
     * 
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug){
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()],
                 301);
        }
        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' =>$property
        ]);
    }
}
