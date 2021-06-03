<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        # Toutes les entités que l'on va récupérer via le repository vont automatiquement être traquées par l'entity manager -> em
        $this->em = $em;
    }

    /** 
     * @Route("/biens", name="property.index")
     * @return Response */

    public function index(): Response
    {
        $property = $this->repository->findAllVisible();
        dump($property);
        $property[0]->setSold(true);
        $this->em->flush();

        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);
        // $property = new Property();
        // $property->setTitle("Mon premier bien")
        //     ->setPrice(200000)
        //     ->setRooms(4)
        //     ->setBedrooms(3)
        //     ->setDescription('Une petite description')
        //     ->setSurface(60)
        //     ->setFloor(4)
        //     ->setHeat(1)
        //     ->setCity('Montpellier')
        //     ->setAddress('Boulevard Gambetta')
        //     ->setPostalCode(34000);

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush();

        // $repository = $this->getDoctrine()->getRepository(Property::class);
        // dump($repository);

        // Les méthodes ci-dessous nous permettent de récupérer les données déclarées précédemment au dessus (voir commentaires $property)
        // Si aucunes ne convient, on peut en créer de nouvelles directement dans notre repository
        // find() -> va récupérer l'enregistrement à l'ID correspondant
        // $property = $this->repository->find(1);
        // findAll() -> va renvoyer un tableau contenant l'ensemble de mes enregistrements (ici mes biens)
        // $property = $this->repository->findAll();
        // findOneBy() -> il prend en params des critères et va renvoyer les éléments correspondants
        // $property = $this->repository->findOneBy(["floor" => 4]);
    }
}
