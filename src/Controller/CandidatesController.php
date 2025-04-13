<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Entity\Entretien;
use App\Entity\Role;
use App\Entity\Offre;
use App\Form\CandidateType;
use App\Entity\StatusEntretien;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatesRepository;


class CandidatesController extends AbstractController
{
    #[Route('/Candidates/{id_offre}', name: 'app_Candidates', methods: ['GET', 'POST'])]
    public function index(Request $request, int $id_offre, EntityManagerInterface $em): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(CandidateType::class, $utilisateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier téléchargé
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $cvFile */
            $cvFile = $form->get('uploaded_cv')->getData();
    
            if ($cvFile) {
                // Générer un nom unique pour le fichier
                $newFilename = uniqid() . '.' . $cvFile->guessExtension();
    
                // Déplacer le fichier dans le répertoire 'uploads/cvs'
                $cvFile->move(
                    $this->getParameter('uploads_directory'), // Spécifier le répertoire de stockage
                    $newFilename
                );
    
                // Enregistrer le nom du fichier dans l'entité
                $utilisateur->setUploadedCv($newFilename);
            }
    
            // Persister l'utilisateur dans la base de données
            $em->persist($utilisateur);
            $em->flush();
    
            // Créer et persister l'entité Entretien
            $entretien = new Entretien();
            $entretien->setIdCondidate($utilisateur->getIdEmploye());
            $offre = $em->getReference(Offre::class, $id_offre);
            $entretien->setOffre($offre);
            $entretien->setDatePostulation(new \DateTime());
            $entretien->setStatus(StatusEntretien::EN_COURS);
    
            $em->persist($entretien);
            $em->flush();
    
            $this->addFlash('success', 'Votre candidature a été enregistrée avec succès !');
            return $this->redirectToRoute('app_home');
        }
    
        return $this->render('includes/addCandidates.html.twig', [
            'form' => $form->createView(),
            'id_offre' => $id_offre,
        ]);
    }
    
}