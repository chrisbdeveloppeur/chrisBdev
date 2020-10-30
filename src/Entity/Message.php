<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de charactères spéciaux (ex: / {} <>)",
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre prénom ne doit pas contenir de charactères spéciaux (ex: / {} <>)",
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre email ne doit pas contenir de charactères spéciaux (ex: / {} <>)",
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="l'objet ne doit pas contenir de charactères spéciaux (ex: / {} <>)",
     * )
     */
    private $objet;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre message ne doit pas contenir de charactères spéciaux (ex: / {} <>)",
     * )
     * @Assert\Length(
     *     max="1000",
     *     maxMessage="1000 charactères maximum"
     * )
     * @Assert\NotBlank()
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
