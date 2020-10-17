<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 * @Vich\Uploadable
 */
class Projet
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
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *     max="500",
     *     maxMessage="500 charactères maximum autorisé")
     */
    private $text;


    /**
     * @var @ORM\Column(type="string", nullable=true)
     */
    private $date_real;

    /**
     *
     * @Vich\UploadableField(mapping="img_projet", fileNameProperty="img_projet_name")
     *
     * @var File|null
     * @Assert\Image(
     *     maxSize="8Mi",
     *     mimeTypes={"image/jpeg", "image/png", "image/svg+xml"},
     *     mimeTypesMessage = "Seul les fichier jpg/jpeg/png/svg sont acceptés")
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_projet_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typedev;

    /**
     * @ORM\ManyToMany(targetEntity=Techno::class, inversedBy="projets")
     */
    private $techno;

    /**
     * @ORM\ManyToMany(targetEntity=Attribut::class, mappedBy="projet")
     */
    private $attributs;


    public function __construct()
    {
        $this->techno = new ArrayCollection();
        $this->attributs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
     * @return File|null
     */
    public function getImg(): ?File
    {
        return $this->img;
    }

    /**
     * @param File|null $img
     * @return Projet
     */
    public function setImg(?File $img): Projet
    {
        $this->img = $img;
        if ($this->img instanceof UploadedFile){
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImgProjetName(): ?string
    {
        return $this->img_projet_name;
    }

    /**
     * @param mixed $img_projet_name
     * @return Projet
     */
    public function setImgProjetName($img_projet_name): Projet
    {
        $this->img_projet_name = $img_projet_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Projet
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateReal()
    {
        return $this->date_real;
    }

    /**
     * @param mixed $date_real
     */
    public function setDateReal($date_real)
    {
        $this->date_real = $date_real;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getTypedev(): ?string
    {
        return $this->typedev;
    }

    public function setTypedev(?string $typedev): self
    {
        $this->typedev = $typedev;

        return $this;
    }

    /**
     * @return Collection|Techno[]
     */
    public function getTechno(): Collection
    {
        return $this->techno;
    }

    public function addTechno(Techno $techno): self
    {
        if (!$this->techno->contains($techno)) {
            $this->techno[] = $techno;
        }

        return $this;
    }

    public function removeTechno(Techno $techno): self
    {
        if ($this->techno->contains($techno)) {
            $this->techno->removeElement($techno);
        }

        return $this;
    }

    /**
     * @return Collection|Attribut[]
     */
    public function getAttributs(): Collection
    {
        return $this->attributs;
    }

    public function addAttribut(Attribut $attribut): self
    {
        if (!$this->attributs->contains($attribut)) {
            $this->attributs[] = $attribut;
            $attribut->addProjet($this);
        }

        return $this;
    }

    public function removeAttribut(Attribut $attribut): self
    {
        if ($this->attributs->contains($attribut)) {
            $this->attributs->removeElement($attribut);
            $attribut->removeProjet($this);
        }

        return $this;
    }




}
