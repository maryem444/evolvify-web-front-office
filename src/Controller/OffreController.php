<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Entity\Status;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OffreRepository;

class OffreController extends AbstractController
{

    
    #[Route('/Offre', name: 'app_Offre')]
    public function listOffres(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les offres depuis la base de données
        $offres = $entityManager->getRepository(Offre::class)->findAll();

        return $this->render('includes/services.html.twig', [
            'offres' => $offres,
        ]);
        
    }


}