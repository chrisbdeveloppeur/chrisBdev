<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PresentationRepository::class)
 * @Vich\Uploadable
 */
class Presentation
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sub_title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *     max="1000",
     *     maxMessage="1000 charactères maximum autorisé"
     * )
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $button_link;

    /**
     *
     * @Vich\UploadableField(mapping="img_presentation", fileNameProperty="img_name")
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
    private $img_name;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

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

    public function getSubTitle(): ?string
    {
        return $this->sub_title;
    }

    public function setSubTitle(?string $sub_title): self
    {
        $this->sub_title = $sub_title;

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
     * @return mixed
     */
    public function getButtonLink()
    {
        return $this->button_link;
    }

    /**
     * @param mixed $button_link
     * @return Presentation
     */
    public function setButtonLink($button_link)
    {
        $this->button_link = $button_link;
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
     * @return Presentation
     */
    public function setImg(?File $img): Presentation
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
    public function getImgName(): ?string
    {
        return $this->img_name;
    }

    /**
     * @param mixed $img_name
     * @return Presentation
     */
    public function setImgName(?string $img_name): Presentation
    {
        $this->img_name = $img_name;
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
     * @return Presentation
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
