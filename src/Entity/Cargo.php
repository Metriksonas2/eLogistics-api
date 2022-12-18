<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CargoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CargoRepository::class)]
#[ApiResource(
    uriTemplate: '/cargos',
    operations: [ new GetCollection(
        normalizationContext: ['groups' => ['cargos_get_collection']]
    ), new Post() ],
)]
#[ApiResource(
    uriTemplate: '/cargos/{id}',
    operations: [ new Get(
        normalizationContext: ['groups' => ['cargos_get']]
    ), new Put(
        security: "is_granted('ROLE_ADMIN') or object.getOwner() == user"
    ),
        new Delete(security: "is_granted('ROLE_ADMIN') or object.getOwner() == user") ],
    uriVariables: [
        'id' => new Link(fromClass: Cargo::class),
    ]
)]
#[ApiResource(
    uriTemplate: '/vehicles/{vehicleId}/cargos',
    operations: [ new GetCollection(), new Post() ],
    uriVariables: [
        'vehicleId' => new Link(fromClass: Vehicle::class, toProperty: 'vehicle'),
    ]
)]
#[ApiResource(
    uriTemplate: '/vehicles/{vehicleId}/cargos/{id}',
    operations: [ new Get(), new Put(), new Delete() ],
    uriVariables: [
        'vehicleId' => new Link(fromClass: Vehicle::class, toProperty: 'vehicle'),
        'id' => new Link(fromClass: Cargo::class),
    ]
)]
#[ApiResource(
    uriTemplate: '/users/{userId}/cargos',
    operations: [ new GetCollection(
        normalizationContext: ['groups' => ['users_cargos_get_collection']]
    ), new Post() ],
    uriVariables: [
        'userId' => new Link(fromClass: User::class, toProperty: 'owner'),
    ],
    security: "is_granted('ROLE_ADMIN') or userId == user.getId()"
)]
#[ApiResource(
    uriTemplate: '/users/{userId}/cargos/{id}',
    operations: [ new Get(
        normalizationContext: ['groups' => ['users_cargos_get']]
    ), new Put(), new Delete() ],
    uriVariables: [
        'userId' => new Link(fromClass: User::class, toProperty: 'owner'),
        'id' => new Link(fromClass: Cargo::class),
    ],
    security: "is_granted('ROLE_ADMIN') or userId == user.getId()"
)]
class Cargo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?string $identifier = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?string $color = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?float $totalWeight = null;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, inversedBy: 'cargos')]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToMany(targetEntity: Item::class, mappedBy: 'cargos')]
    #[Link(toProperty: 'cargos')]
    #[Groups(['cargos_get', 'cargos_get_collection',
        'users_cargos_get', 'users_cargos_get_collection'])]
    private Collection $items;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cargos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['users_cargos_get', 'users_cargos_get_collection'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getTotalWeight(): ?float
    {
        return $this->totalWeight;
    }

    public function setTotalWeight(float $totalWeight): self
    {
        $this->totalWeight = $totalWeight;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->addCargo($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            $item->removeCargo($this);
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
