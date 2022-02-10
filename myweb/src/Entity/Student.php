<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 9)]
    private $sid;

    #[ORM\Column(type: 'string', length: 30)]
    private $sname;

    #[ORM\Column(type: 'date')]
    private $sdob;

    #[ORM\Column(type: 'float')]
    private $sgrade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function setSid(string $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    public function getSname(): ?string
    {
        return $this->sname;
    }

    public function setSname(string $sname): self
    {
        $this->sname = $sname;

        return $this;
    }

    public function getSdob(): ?\DateTimeInterface
    {
        return $this->sdob;
    }

    public function setSdob(\DateTimeInterface $sdob): self
    {
        $this->sdob = $sdob;

        return $this;
    }

    public function getSgrade(): ?float
    {
        return $this->sgrade;
    }

    public function setSgrade(float $sgrade): self
    {
        $this->sgrade = $sgrade;

        return $this;
    }
}
