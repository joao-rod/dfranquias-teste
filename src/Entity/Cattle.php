<?php

namespace App\Entity;

use App\Repository\CattleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CattleRepository::class)]
#[UniqueEntity('cod', message: "Esse código já existe no sistema")]
class Cattle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, unique: true)]
    #[Assert\Positive(message: 'Valor inválido! Você deve inserir um valor positivo')]
    private ?string $cod = null;

    #[ORM\Column]
    private ?float $milk = null;

    #[ORM\Column]
    private ?float $week_portion = null;

    #[ORM\Column]
    private ?float $cattle_weight = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birth = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCod(): ?string
    {
        return $this->cod;
    }

    public function setCod(string $cod): self
    {
        $this->cod = $cod;

        return $this;
    }

    public function getMilk(): ?float
    {
        return $this->milk;
    }

    public function setMilk(float $milk): self
    {
        $this->milk = $milk;

        return $this;
    }

    public function getWeekPortion(): ?float
    {
        return $this->week_portion;
    }

    public function setWeekPortion(float $week_portion): self
    {
        $this->week_portion = $week_portion;

        return $this;
    }

    public function getCattleWeight(): ?float
    {
        return $this->cattle_weight;
    }

    public function setCattleWeight(float $cattle_weight): self
    {
        $this->cattle_weight = $cattle_weight;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }
}
