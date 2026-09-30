<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[UniqueEntity(
    fields: ['first_name', 'last_name', 'middle_name', 'birthdate'],
    message: 'Такой студент уже существует',
    ignoreNull: 'middle_name'
)]


#[ORM\UniqueConstraint(
    name: 'UNIQ_student_name',
    columns: ['first_name', 'last_name', 'middle_name', 'birthdate']
)]

class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $middle_name = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentsGroup $students_group = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $birthdate = null;

    #[ORM\OneToOne(mappedBy: 'student', cascade: ['persist', 'remove'])]
    private ?Contact $contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(?string $middle_name): static
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getStudentsGroup(): ?StudentsGroup
    {
        return $this->students_group;
    }

    public function setStudentsGroup(?StudentsGroup $students_group): static
    {
        $this->students_group = $students_group;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setStudent(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getStudent() !== $this) {
            $contact->setStudent($this);
        }

        $this->contact = $contact;

        return $this;
    }
}
