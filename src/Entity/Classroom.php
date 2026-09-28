<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Такой кабинет уже существует'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_classroom_name',
    columns: ['name']
)]

class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'classrooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassroomType $classroom_type = null;

    #[ORM\ManyToOne(inversedBy: 'classrooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\ManyToOne(inversedBy: 'classrooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    /**
     * @var Collection<int, Pair>
     */
    #[ORM\OneToMany(targetEntity: Pair::class, mappedBy: 'classroom')]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getClassroomType(): ?ClassroomType
    {
        return $this->classroom_type;
    }

    public function setClassroomType(?ClassroomType $classroom_type): static
    {
        $this->classroom_type = $classroom_type;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;

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
            $pair->setClassroom($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): static
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getClassroom() === $this) {
                $pair->setClassroom(null);
            }
        }

        return $this;
    }
}
