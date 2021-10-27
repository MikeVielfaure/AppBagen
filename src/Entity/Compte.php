<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @UniqueEntity("intitule", message="nom déja utilisé")
 */
class Compte
{
    public function getLadatecreation(): ?string
    {
        return $this->datecreation->format('d-m-Y');
    }
    
    public function getLadatemodifie(): ?string
    {
        return $this->datemodif->format('d-m-Y');
    }
    
    public function getLadatecloture(): ?string
    {
        
        if($this->datecloture != null){
        return $this->datecloture->format('d-m-Y');
        }else{
            return " ";
        }
    }
            
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $intitule;

    /**
     * @ORM\Column(type="date")
     * 
     */
    private $datecreation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datecloture;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idutilisateur;

    /**
     * @ORM\Column(type="date")
     */
    private $datemodif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDatecreation(): ?DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDatecloture(): ?DateTimeInterface
    {
        return $this->datecloture;
    }

    public function setDatecloture(?DateTimeInterface $datecloture): self
    {
        $this->datecloture = $datecloture;

        return $this;
    }

    public function getIdutilisateur(): ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function setIdutilisateur(?Utilisateur $idutilisateur): self
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    public function getDatemodif(): ?DateTimeInterface
    {
        return $this->datemodif;
    }

    public function setDatemodif(DateTimeInterface $datemodif): self
    {
        $this->datemodif = $datemodif;

        return $this;
    }
    
    
    /**
     * @ORM\OneToMany(targetEntity=Depense::class, mappedBy="idcompte")
     */
    private $depenses;
    
    
    /**
     * @return Collection|Depense[]
     */
    public function getDepenses(): Collection
    {
        return $this->depenses;
    }
    
    /**
     *
     * @var float
     */
    private $totalDepense;
    
    /**
     * 
     * @return float
     */
    public function getTotalDepense(): float
    {
        $montant = 0.0;
        foreach ($this->depenses as $depense){
            $montant = $montant + $depense->getMontant();
        }
        $this->totalDepense = $montant;
        return $this->totalDepense;
    }
    
    
    /**
     * @ORM\OneToMany(targetEntity=Budget::class, mappedBy="idcompte")
     */
    private $budget;
    
    /**
     * @return Collection|Budget[]
     */
    public function getBudget(): Collection
    {
        return $this->budget;
    }
    
    /**
     *
     * @var float
     */
    private $leBudget;
    
    public function getLeBudget() : float
    {
        if($this->budget[0] != null){
        $this->leBudget = $this->budget[0]->getMontant();
        return $this->leBudget;
        }else{
            return 0;
        }
    }
    
    /**
     *
     * @var float
     */
    private $monBudget;
    
    public function getMonBudget() : float
    {
        
        return $this->monBudget;
    }
    
    
    /**
     * 
     * @return int
     */
    public function getPourcentageBudgetDepense(): int
    {
        return round(($this->getTotalDepense()/$this->getLeBudget()) *100,0,PHP_ROUND_HALF_DOWN);
    }
    
    /**
     * retourne budget - depenses
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getLeBudget()-$this->getTotalDepense();
    }
    
    
}
