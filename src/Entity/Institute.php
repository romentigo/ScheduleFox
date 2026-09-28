<?php

namespace App\Entity;

use App\Repository\InstituteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: InstituteRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Такой институт уже существует'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_institute_name',
    columns: ['name']
)]

class Institute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Department>
     */
    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'institute')]
    private Collection $departments;

    /**
     * @var Collection<int, Speciality>
     */
    #[ORM\OneToMany(targetEntity: Speciality::class, mappedBy: 'institute')]
    private Collection $specialities;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->specialities = new ArrayCollection();
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
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): static
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setInstitute($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): static
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getInstitute() === $this) {
                $department->setInstitute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): static
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
            $speciality->setInstitute($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): static
    {
        if ($this->specialities->removeElement($speciality)) {
            // set the owning side to null (unless already changed)
            if ($speciality->getInstitute() === $this) {
                $speciality->setInstitute(null);
            }
        }

        return $this;
    }
}
