<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Entity\StatusEntretien;
#[ORM\Entity]
#[ORM\Table(name: "liste_offres")]
class Entretien
{
   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_liste_offres;

    #[ORM\Column]
    private int $id_condidat;

    #[ORM\ManyToOne(targetEntity: Offre::class)]
    #[ORM\JoinColumn(name: "id_offre", referencedColumnName: "id_offre", onDelete: "CASCADE")]
    private ?Offre $offre = null;
    

    #[ORM\Column(type: "string", enumType: StatusEntretien::class)]
    private StatusEntretien $status = StatusEntretien::EN_COURS;
    

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePostulation = null;





    // Getters et Setters
    public function getIdListOffre(): ?int
    {
        return $this->id_list_offres;
    }

    public function getIdCondidate(): int
    {
        return $this->id_condidat;
    }

    public function setIdCondidate(int $idCondidate): self
    {
        $this->id_condidat = $idCondidate;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(Offre $offre): self
    {
        $this->offre = $offre;
        return $this;
    }
    public function getStatus(): StatusEntretien
    {
        return $this->status;
    }

    public function setStatus(StatusEntretien $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getDatePostulation(): ?\DateTimeInterface
    {
        return $this->datePostulation;
    }

    public function setDatePostulation(?\DateTimeInterface $datePostulation): self
    {
        $this->datePostulation = $datePostulation;
        return $this;
    }

    
}
