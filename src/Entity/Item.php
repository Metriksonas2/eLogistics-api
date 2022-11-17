<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/cargos/{cargosId}/items',
    operations: [ new GetCollection(), new Post() ],
    uriVariables: [
        'cargosId' => new Link(fromClass: Cargo::class, toProperty: 'cargos'),
    ]
)]
#[ApiResource(
    uriTemplate: '/cargos/{cargosId}/items/{id}',
    operations: [ new Get(), new Put(), new Delete() ],
    uriVariables: [
        'cargosId' => new Link(fromClass: Cargo::class, toProperty: 'cargos'),
        'id' => new Link(fromClass: Item::class),
    ]
)]
#[ApiResource(
    uriTemplate: 'vehicles/{vehicleId}/cargos/{cargosId}/items',
    operations: [ new GetCollection(), new Post() ],
    uriVariables: [
        'vehicleId' => new Link(fromClass: Vehicle::class, toProperty: 'vehicle'),
        'cargosId' => new Link(fromClass: Cargo::class, toProperty: 'cargos'),
    ]
)]
#[ApiResource(
    uriTemplate: 'vehicles/{vehicleId}/cargos/{cargosId}/items/{id}',
    operations: [ new Get(), new Put(), new Delete() ],
    uriVariables: [
        'vehicleId' => new Link(fromClass: Vehicle::class, toProperty: 'vehicle'),
        'cargosId' => new Link(fromClass: Cargo::class, toProperty: 'cargos'),
        'id' => new Link(fromClass: Item::class),
    ]
)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private ?float $weight = null;

    #[ORM\ManyToMany(targetEntity: Cargo::class, inversedBy: 'items')]
    private Collection $cargos;

    public function __construct()
    {
        $this->cargos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection<int, Cargo>
     */
    public function getCargos(): Collection
    {
        return $this->cargos;
    }

    public function addCargo(Cargo $cargo): self
    {
        if (!$this->cargos->contains($cargo)) {
            $this->cargos->add($cargo);
        }

        return $this;
    }

    public function removeCargo(Cargo $cargo): self
    {
        $this->cargos->removeElement($cargo);

        return $this;
    }
}
