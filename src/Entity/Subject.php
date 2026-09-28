<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Такой предмет уже существует'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_subject_name',
    columns: ['name']
)]

class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    /**
     * @var Collection<int, Pair>
     */
    #[ORM\OneToMany(targetEntity: Pair::class, mappedBy: 'subject')]
    private Collection $pairs;

    public function __construct()
    {
        $this->pairs = new ArrayCollection();
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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection<int, Pair>
     */
    public function getPairs(): Collection
    {
        return $this->pairs;
    }

    public function addPair(Pair $pair): static
    {
        if (!$this->pairs->contains($pair)) {
            $this->pairs->add($pair);
            $pair->setSubject($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): static
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getSubject() === $this) {
                $pair->setSubject(null);
            }
        }

        return $this;
    }
}
