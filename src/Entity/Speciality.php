<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Такая специальность уже существует'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_speciality_name',
    columns: ['name']
)]

class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'specialities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Institute $institute = null;

    /**
     * @var Collection<int, StudentsGroup>
     */
    #[ORM\OneToMany(targetEntity: StudentsGroup::class, mappedBy: 'speciality')]
    private Collection $studentsGroups;

    public function __construct()
    {
        $this->studentsGroups = new ArrayCollection();
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

    public function getInstitute(): ?Institute
    {
        return $this->institute;
    }

    public function setInstitute(?Institute $institute): static
    {
        $this->institute = $institute;

        return $this;
    }

    /**
     * @return Collection<int, StudentsGroup>
     */
    public function getStudentsGroups(): Collection
    {
        return $this->studentsGroups;
    }

    public function addStudentsGroup(StudentsGroup $studentsGroup): static
    {
        if (!$this->studentsGroups->contains($studentsGroup)) {
            $this->studentsGroups->add($studentsGroup);
            $studentsGroup->setSpeciality($this);
        }

        return $this;
    }

    public function removeStudentsGroup(StudentsGroup $studentsGroup): static
    {
        if ($this->studentsGroups->removeElement($studentsGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentsGroup->getSpeciality() === $this) {
                $studentsGroup->setSpeciality(null);
            }
        }

        return $this;
    }
}
