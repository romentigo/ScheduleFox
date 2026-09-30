<?php

namespace App\Entity;

use App\Repository\StudentsGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StudentsGroupRepository::class)]
#[UniqueEntity(
    fields: ['course_num', 'group_num', 'speciality_id']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_studGroup',
    columns: ['course_num', 'group_num', 'speciality_id']
)]

class StudentsGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $course_num = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $group_num = null;

    #[ORM\ManyToOne(inversedBy: 'studentsGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Speciality $speciality = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'students_group')]
    private Collection $students;

    /**
     * @var Collection<int, Pair>
     */
    #[ORM\OneToMany(targetEntity: Pair::class, mappedBy: 'students_group')]
    private Collection $pairs;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->pairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseNum(): ?int
    {
        return $this->course_num;
    }

    public function setCourseNum(int $course_num): static
    {
        $this->course_num = $course_num;

        return $this;
    }

    public function getGroupNum(): ?int
    {
        return $this->group_num;
    }

    public function setGroupNum(int $group_num): static
    {
        $this->group_num = $group_num;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): static
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setStudentsGroup($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getStudentsGroup() === $this) {
                $student->setStudentsGroup(null);
            }
        }

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
            $pair->setStudentsGroup($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): static
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getStudentsGroup() === $this) {
                $pair->setStudentsGroup(null);
            }
        }

        return $this;
    }
}
