<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\AppCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppCategoryRepository::class)]
class AppCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $identificator = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: App::class)]
    private Collection $apps;

    public function __construct()
    {
        $this->apps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdentificator(): ?string
    {
        return $this->identificator;
    }

    public function setIdentificator(string $identificator): self
    {
        $this->identificator = $identificator;

        return $this;
    }

    /**
     * @return Collection<int, App>
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }

    public function addApp(App $app): self
    {
        if (!$this->apps->contains($app)) {
            $this->apps->add($app);
            $app->setCategory($this);
        }

        return $this;
    }

    public function removeApp(App $app): self
    {
        if ($this->apps->removeElement($app)) {
            // set the owning side to null (unless already changed)
            if ($app->getCategory() === $this) {
                $app->setCategory(null);
            }
        }

        return $this;
    }
}
