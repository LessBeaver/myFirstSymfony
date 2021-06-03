<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\Persistence\ObjectManager;
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
     * @var EntityManagerInterface
     */
    private $em;

    # Toutes les entités que l'on va récupérer via le repository vont automatiquement être traquées par l'entity manager -> em
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /** 
     * @Route("/biens", name="property.index")
     * @return Response */

    public function index(): Response
    {
        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);

        // La 1ère chose à faire est de créer une property puis d'enchaîner les setter afin de remplir celle-ci
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

    /** 
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response */

    //  Cette méthode permet de rediriger l'utilisateur vers le bon lien (lien canonique) en cas d'erreur dans la rédaction de l'url -> très important pour le référencement
    public function show(Property $property, string $slug): Response
    // public function show($slug, $id): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        // $property = $this->repository->find($id);
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
