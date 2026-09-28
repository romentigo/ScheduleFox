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
#[UniqueEntity(
    fields: ['email'],
    message: 'Такой email уже существует',
)]
#[UniqueEntity(
    fields: ['phone_number'],
    message: 'Такой номер телефона уже существует',
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_student_name',
    columns: ['first_name', 'last_name', 'middle_name', 'birthdate']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_student_email',
    columns: ['email']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_student_phoneNumber',
    columns: ['phone_number']
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

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentsGroup $students_group = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $birthdate = null;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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
}
