<?php

namespace App\Entity;

use App\Repository\DepenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepenseRepository::class)
 */
class Depense
{
    
    public function getLadate(): ?string
    {
        return $this->date->format('d-m-Y');
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=compte::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idcompte;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $datemodif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdcompte(): ?compte
    {
        return $this->idcompte;
    }

    public function setIdcompte(?compte $idcompte): self
    {
        $this->idcompte = $idcompte;

        return $this;
    }

    public function getDatemodif(): ?string
    {
        return $this->datemodif;
    }

    public function setDatemodif(?string $datemodif): self
    {
        $this->datemodif = $datemodif;

        return $this;
    }
}
