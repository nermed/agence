<?php

namespace App\Controller\Property;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use Doctrine\ORM\EntityManager;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
//use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
    );
        
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'properties' => $properties,
            'form' => $form->createView()
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
    public function show(Property $property, string $slug, Request $request, ContactNotification $contactNotification): Response
    {
        if($property->getSlug() !== $slug){
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()],
                 301);
        }
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /*$contactNotification->notify($contact);*/
            $this->addFlash('success', 'Votre message a été bien envoyé');
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()],
            );

        }
        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' =>$property,
            'form' => $form->createView()
        ]);
    }
}
