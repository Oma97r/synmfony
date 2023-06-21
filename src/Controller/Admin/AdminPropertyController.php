<?php
namespace App\Controller\Admin;


use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController{
    private $propertyRypository;

    /**
     *@var PropertyRepository
     */
    public function __construct(PropertyRepository $propertyRypository,ObjectManager $em) {
        $this->propertyRypository = $propertyRypository;
        $this->em = $em;

    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Symfony\Component\HttpFoundation\Response
     */

    public function index():Response{
        $properties = $this->propertyRypository->findAll();
        return $this->render('admin/index.html.twig',['properties' => $properties]);
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request    ){
        $property = new Property;
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();

            return $this->redirectToRoute('admin.property.index');

        } 
        return $this->render('admin/property/new.html.twig',['properties' => $property, 'form' => $form->createView()]);

    }



         

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete",methods="DELETE")
     * @param Property $property
     * @return Response
     */
    public function delete(Property $property,Request $request):Response{

        if ($this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token'))){

            $form = $this->createForm(PropertyType::class, $property);
            $this ->em->remove($property);
            $this->em->flush();
        }
        
       
        

        return $this->redirectToRoute('admin.property.index');


    }
    /**
     * @Route("/admin/property/{id}", name="admin.property.edit",methods="GET|POST")
     * @param Property $property
     * @return Symfony\Component\HttpFoundation\Response
     */

    public function edit(Property $property,Request $request):Response{

        // $option = new Option();
        // $property->addOption($option);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succés !');
            

            return $this->redirectToRoute('admin.property.index');

        } 


        return $this->render('admin/property/edit.html.twig',['properties' => $property, 'form' => $form->createView()]);

    }


}