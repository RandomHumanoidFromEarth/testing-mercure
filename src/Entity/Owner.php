<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
#[ApiResource]
class Owner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Puppy>
     */
    #[ORM\OneToMany(targetEntity: Puppy::class, mappedBy: 'owner', orphanRemoval: true)]
    private Collection $puppies;

    public function __construct()
    {
        $this->puppies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Puppy>
     */
    public function getPuppies(): Collection
    {
        return $this->puppies;
    }

    public function addPuppy(Puppy $puppy): static
    {
        if (!$this->puppies->contains($puppy)) {
            $this->puppies->add($puppy);
            $puppy->setOwner($this);
        }

        return $this;
    }

    public function removePuppy(Puppy $puppy): static
    {
        if ($this->puppies->removeElement($puppy)) {
            // set the owning side to null (unless already changed)
            if ($puppy->getOwner() === $this) {
                $puppy->setOwner(null);
            }
        }

        return $this;
    }
}
