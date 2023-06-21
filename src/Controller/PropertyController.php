<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;

use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager; 
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController {

    public function __construct(PropertyRepository $repository,ObjectManager $em ) {
        $this ->repository = $repository;
        $this ->em = $em;

    }



    /**
     *@Route("/biens",name="property.index")
     *@return Response 
     */

    public function index(PropertyRepository $repository,PaginatorInterface $paginator, Request $request):Response{

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties= $paginator->paginate($this->repository->findAllvisibleQuery($search),
         $request->query->getInt('page', 1), /*page number*/
        12 /*limit per page*/);

        //$property = $this->repository->findAllVisible();
        // $property[0]->setSold(true) ; 
        
        // $this->em->flush();      
        //dump($property);
        return $this->render('property/index.html.twig',[
            'current_menu'=>'properties','properties'=>$properties,'form' => $form-> createView()
        ]);

    }

    /**
     *@Route("/biens/{slug}-{id}",name="property.show",requirements={"slug":"[a-z0-9\-]*"})
     *@return Response
     */
    public function show(Property $property,String $slug):Response
    {
        if ($property->getSlug() !== $slug) 
        {
          return  $this->redirectToRoute('property.show',[
                'id' =>$property->getId(),'slug' =>$property->getSlug()
            ],301);
        }
        return $this->render('property/show.html.twig',[
            'current_menu'=>'properties',"property"=>$property
        ]);
    }
}