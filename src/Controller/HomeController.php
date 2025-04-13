<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Offre;
use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OffreRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les offres depuis la base de données
        $offres = $entityManager->getRepository(Offre::class)->findAll();
            // Transmettre les offres à la vue de base
         return $this->render('base.html.twig', [
            'offres' => $offres,  // Passe les offres à la vue
        ]);
    }
}
