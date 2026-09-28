<?php

namespace App\Entity;

use App\Repository\PairRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PairRepository::class)]
#[UniqueEntity(
    fields: ['teacher_id', 'pair_number_id', 'day_id', 'week_id'],
    message: 'Этот преподаватель уже занят в это время.'
)]
#[UniqueEntity(
    fields: ['stud_group_id', 'pair_number_id', 'day_id', 'week_id'],
    message: 'Эта группа уже занята в это время.'
)]
#[UniqueEntity(
    fields: ['classroom_id', 'pair_number_id', 'day_id', 'week_id'],
    message: 'Эта аудитория уже занята в это время.'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_pair_teacher',
    columns: ['teacher_id', 'pair_number_id', 'day_id', 'week_id']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_pair_stud_group',
    columns: ['stud_group_id', 'pair_number_id', 'day_id', 'week_id']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_pair_classroom',
    columns: ['classroom_id', 'pair_number_id', 'day_id', 'week_id']
)]

class Pair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classroom $classroom = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Day $day = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentsGroup $students_group = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    private ?Teacher $teacher = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PairNumber $pair_number = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PairType $pair_type = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subject $subject = null;

    #[ORM\ManyToOne(inversedBy: 'pairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Week $week = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): static
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): static
    {
        $this->day = $day;

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

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getPairNumber(): ?PairNumber
    {
        return $this->pair_number;
    }

    public function setPairNumber(?PairNumber $pair_number): static
    {
        $this->pair_number = $pair_number;

        return $this;
    }

    public function getPairType(): ?PairType
    {
        return $this->pair_type;
    }

    public function setPairType(?PairType $pair_type): static
    {
        $this->pair_type = $pair_type;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): static
    {
        $this->week = $week;

        return $this;
    }
}
