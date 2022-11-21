<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppRepository::class)]
class App
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $identificator = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $score = null;

    #[ORM\Column(length: 255)]
    private ?string $app_url = null;

    #[ORM\Column(length: 255)]
    private ?string $icon_url = null;

    #[ORM\ManyToOne(inversedBy: 'apps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AppCategory $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentificator(): ?string
    {
        return $this->identificator;
    }

    public function setIdentificator(string $identificator): self
    {
        $this->identificator = $identificator;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getAppUrl(): ?string
    {
        return $this->app_url;
    }

    public function setAppUrl(string $app_url): self
    {
        $this->app_url = $app_url;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->icon_url;
    }

    public function setIconUrl(string $icon_url): self
    {
        $this->icon_url = $icon_url;

        return $this;
    }

    public function getCategory(): ?AppCategory
    {
        return $this->category;
    }

    public function setCategory(?AppCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
