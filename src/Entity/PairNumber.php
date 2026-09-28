<?php

namespace App\Entity;

use App\Repository\PairNumberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PairNumberRepository::class)]
#[UniqueEntity(
    fields: ['pair_number'],
    message: 'Такой номер пары уже существует'
)]
#[UniqueEntity(
    fields: ['start'],
    message: 'В это время уже начинается другая пара'
)]
#[UniqueEntity(
    fields: ['finish'],
    message: 'В это время уже заканчивается другая пара'
)]

#[ORM\UniqueConstraint(
    name: 'UNIQ_pairNumber_number',
    columns: ['pair_number']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_pairNumber_start',
    columns: ['start']
)]
#[ORM\UniqueConstraint(
    name: 'UNIQ_pairNumber_finish',
    columns: ['finish']
)]

class PairNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $pair_number = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $finish = null;

    /**
     * @var Collection<int, Pair>
     */
    #[ORM\OneToMany(targetEntity: Pair::class, mappedBy: 'pair_number')]
    private Collection $pairs;

    public function __construct()
    {
        $this->pairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPairNumber(): ?int
    {
        return $this->pair_number;
    }

    public function setPairNumber(int $pair_number): static
    {
        $this->pair_number = $pair_number;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getFinish(): ?\DateTime
    {
        return $this->finish;
    }

    public function setFinish(\DateTime $finish): static
    {
        $this->finish = $finish;

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
            $pair->setPairNumber($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): static
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getPairNumber() === $this) {
                $pair->setPairNumber(null);
            }
        }

        return $this;
    }
}
