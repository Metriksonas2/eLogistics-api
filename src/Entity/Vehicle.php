<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Link;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A vehicle
 */
#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource]
class Vehicle
{
    /**
     * The id of the vehicle
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Capacity of the vehicle's fuel tank
     */
    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private ?int $fuelTankCapacity = null;

    /**
     * The license plate of the vehicle
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $licensePlate = "";

    /**
     * The fuel type of the vehicle
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $fuelType = "";

    /**
     * The gearbox type of the vehicle
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $gearbox = "";

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Cargo::class)]
    #[Link(toProperty: 'vehicle')]
    private Collection $cargos;

    public function __construct()
    {
        $this->cargos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFuelTankCapacity(): ?int
    {
        return $this->fuelTankCapacity;
    }

    public function setFuelTankCapacity(?int $fuelTankCapacity): void
    {
        $this->fuelTankCapacity = $fuelTankCapacity;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): void
    {
        $this->licensePlate = $licensePlate;
    }

    public function getFuelType(): string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): void
    {
        $this->fuelType = $fuelType;
    }

    public function getGearbox(): string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): void
    {
        $this->gearbox = $gearbox;
    }

    public function getCargos(): Collection
    {
        return $this->cargos;
    }

    public function addCargo(Cargo $cargo): self
    {
        if (!$this->cargos->contains($cargo)) {
            $this->cargos->add($cargo);
            $cargo->setVehicle($this);
        }

        return $this;
    }

    public function removeCargo(Cargo $cargo): self
    {
        if ($this->cargos->removeElement($cargo)) {
            // set the owning side to null (unless already changed)
            if ($cargo->getVehicle() === $this) {
                $cargo->setVehicle(null);
            }
        }

        return $this;
    }
}