<?php

namespace App\Entity;

use App\Repository\MdpoublieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=MdpoublieRepository::class)
 */
class Mdpoublie implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;
    
    /**
     *
     * @var string
     */
    private $mdp;
    
    
    function getMdp(): string {
        return $this->mdp;
    }

    function setMdp(string $mdp): void {
        $this->mdp = $mdp;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        
    }

    

public function getSalt() {
    
}

public function getUsername(): string {
    
    
    
}

/**
* 
* @return string[]
*/
public function getRoles(){
}

}
