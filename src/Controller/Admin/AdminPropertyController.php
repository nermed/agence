<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Service\FileUploader;
//use Doctrine\ORM\EntityManager;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    protected $repository;
    protected $em;

    /**
     * @param PropertyRepository $repository
     * @param EntityManagerInterface $em
     * 
     * @return void
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin_property/admin.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties' => $properties
        ]);
    }
    /**
     * @Route("/admin/new", name="admin_new", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nouveau(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        if($form ->handleRequest($request)->isSubmitted()){
             if($form->isValid()) {
            /*if(!$property->getId()){
                $property -> setCreatedAt(new \DateTime());
            }*/
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
            }
        }
        return $this->render('admin_property/new.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
     /**
     * @Route("/admin/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Request $request
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request, FileUploader $fileUploader)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $property->getImageFile();
            $fileName = $fileUploader->upload($file);
            $property->setFilename($fileName);
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succes');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin_property/edit.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
     /**
     * @Route("/admin/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request)
    {
       if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
       {
           $this->em->remove($property);
           $this->em->flush();
           $this->addFlash('success', 'Supprimé avec success');
           return $this->redirectToRoute('admin.property.index');
       }
    }
}
