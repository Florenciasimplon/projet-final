<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
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
    private $nom_restaurant;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone_restaurant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_restaurant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $parking;

    /**
     * @ORM\Column(type="boolean")
     */
    private $animaux;

    /**
     * @ORM\Column(type="boolean")
     */
    private $climatisation;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="restaurant", orphanRemoval=true)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=Temoignage::class, mappedBy="restaurant", orphanRemoval=true)
     */
    private $temoignage;

    /**
     * @ORM\Column(type="json")
     */
    private $picture_restaurant = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal_restaurant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $acces_handicape;

    /**
     * @ORM\Column(type="integer")
     */
    private $place_maximum;


    public function __construct()
    {
        $this->menu = new ArrayCollection();
        $this->temoignage = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRestaurant(): ?string
    {
        return $this->nom_restaurant;
    }

    public function setNomRestaurant(string $nom_restaurant): self
    {
        $this->nom_restaurant = $nom_restaurant;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTelephoneRestaurant(): ?int
    {
        return $this->telephone_restaurant;
    }

    public function setTelephoneRestaurant(int $telephone_restaurant): self
    {
        $this->telephone_restaurant = $telephone_restaurant;

        return $this;
    }

    public function getAdresseRestaurant(): ?string
    {
        return $this->adresse_restaurant;
    }

    public function setAdresseRestaurant(string $adresse_restaurant): self
    {
        $this->adresse_restaurant = $adresse_restaurant;

        return $this;
    }

    public function getParking(): ?bool
    {
        return $this->parking;
    }

    public function setParking(bool $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getAnimaux(): ?bool
    {
        return $this->animaux;
    }

    public function setAnimaux(bool $animaux): self
    {
        $this->animaux = $animaux;

        return $this;
    }

    public function getClimatisation(): ?bool
    {
        return $this->climatisation;
    }

    public function setClimatisation(bool $climatisation): self
    {
        $this->climatisation = $climatisation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Temoignage[]
     */
    public function getTemoignage(): Collection
    {
        return $this->temoignage;
    }

    public function addTemoignage(Temoignage $temoignage): self
    {
        if (!$this->temoignage->contains($temoignage)) {
            $this->temoignage[] = $temoignage;
            $temoignage->setRestaurant($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): self
    {
        if ($this->temoignage->removeElement($temoignage)) {
            // set the owning side to null (unless already changed)
            if ($temoignage->getRestaurant() === $this) {
                $temoignage->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getPictureRestaurant(): ?array
    {
        return $this->picture_restaurant;
    }

    public function setPictureRestaurant(string $picture_restaurant): self
    {
       array_push($this->picture_restaurant,$picture_restaurant);

        return $this;
    }
    public function resetPictureRestaurant(){
        $this->picture_restaurant=[];
    }

    public function getCodepostalRestaurant(): ?int
    {
        return $this->codepostal_restaurant;
    }

    public function setCodepostalRestaurant(int $codepostal_restaurant): self
    {
        $this->codepostal_restaurant = $codepostal_restaurant;

        return $this;
    }

    public function getAccesHandicape(): ?bool
    {
        return $this->acces_handicape;
    }

    public function setAccesHandicape(bool $acces_handicapé): self
    {
        $this->acces_handicape = $acces_handicapé;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function getPlaceMaximum(): ?int
    {
        return $this->place_maximum;
    }

    public function setPlaceMaximum(int $place_maximum): self
    {
        $this->place_maximum = $place_maximum;

        return $this;
    }
 

   
}
