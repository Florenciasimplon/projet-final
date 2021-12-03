<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_menu;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="menu")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entrer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Plats;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Dessert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entrer_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plats_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Dessert_2;


   
    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getNomMenu(): ?string
    {
        return $this->nom_menu;
    }

    public function setNomMenu(string $nom_menu): self
    {
        $this->nom_menu = $nom_menu;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getEntrer(): ?string
    {
        return $this->entrer;
    }

    public function setEntrer(?string $entrer): self
    {
        $this->entrer = $entrer;

        return $this;
    }

    public function getPlats(): ?string
    {
        return $this->Plats;
    }

    public function setPlats(?string $Plats): self
    {
        $this->Plats = $Plats;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->Dessert;
    }

    public function setDessert(string $Dessert): self
    {
        $this->Dessert = $Dessert;

        return $this;
    }

    public function getEntrer2(): ?string
    {
        return $this->entrer_2;
    }

    public function setEntrer2(?string $entrer_2): self
    {
        $this->entrer_2 = $entrer_2;

        return $this;
    }

    public function getPlats2(): ?string
    {
        return $this->plats_2;
    }

    public function setPlats2(?string $plats_2): self
    {
        $this->plats_2 = $plats_2;

        return $this;
    }

    public function getDessert2(): ?string
    {
        return $this->Dessert_2;
    }

    public function setDessert2(string $Dessert_2): self
    {
        $this->Dessert_2 = $Dessert_2;

        return $this;
    }


}
