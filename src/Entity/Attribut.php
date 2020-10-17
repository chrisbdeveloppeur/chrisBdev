<?php

namespace App\Entity;

use App\Repository\AttributRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributRepository::class)
 */
class Attribut
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity=Projet::class, inversedBy="attributs")
     */
    private $projet;

    public function __construct()
    {
        $this->projet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet[] = $projet;
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projet->contains($projet)) {
            $this->projet->removeElement($projet);
        }

        return $this;
    }
}
