<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   
    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_personnes;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_reservation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_reservation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $restautant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Datereservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRestaurantId(int $restaurant_id): self
    {
        $this->restaurant_id = $restaurant_id;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->nombre_personnes;
    }

    public function setNombrePersonnes(int $nombre_personnes): self
    {
        $this->nombre_personnes = $nombre_personnes;

        return $this;
    }

    public function getHeureReservation(): ?\DateTimeInterface
    {
        return $this->heure_reservation;
    }

    public function setHeureReservation(\DateTimeInterface $heure_reservation): self
    {
        $this->heure_reservation = $heure_reservation;

        return $this;
    }

    public function getDateDeReservation(): ?\DateTimeInterface
    {
        return $this->date_de_reservation;
    }

    public function setDateDeReservation(\DateTimeInterface $date_de_reservation): self
    {
        $this->date_de_reservation = $date_de_reservation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRestautant(): ?Restaurant
    {
        return $this->restautant;
    }

    public function setRestautant(?Restaurant $restautant): self
    {
        $this->restautant = $restautant;

        return $this;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->Datereservation;
    }

    public function setDatereservation(?\DateTimeInterface $Datereservation): self
    {
        $this->Datereservation = $Datereservation;

        return $this;
    }
}
