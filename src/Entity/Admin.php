<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cette adresse email est déjà enregistrée")
 * @ORM\HasLifecycleCallbacks()
 */
class Admin implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $securityToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre prénom ne peut contenir des caratères spéciaux (ex: / {} <>)",
     *)
     * @Assert\Length(
     *     max="100",
     *     maxMessage="100 caractères maximum autorisés pour votre prénom"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *     pattern="/[<>{}\/]/",
     *     match=false,
     *     message="Votre nom ne peut contenir des caratères spéciaux (ex: / {} <>)",
     *)
     * @Assert\Length(
     *     max="100",
     *     maxMessage="100 caractères maximum autorisés pour votre nom"
     * )
     */
    private $last_name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="boolean")
     */
    private $news;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $agree_terms;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enable;

//    /**
//     * @CaptchaAssert\ValidCaptcha(
//     *      message = "Echec de validation CAPTCHA, veuillez reéssayer."
//     * )
//     */
//    protected $captchaCode;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        // Si le statut isConfirmed n'est pas défini: mettre à false
        if ($this->isConfirmed === null) {
            $this->setIsConfirmed(false);
        }

        // Définir un jeton s'il n'y en a pas
        if ($this->securityToken === null) {
            $this->renewToken();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSecurityToken(): ?string
    {
        return $this->securityToken;
    }

    public function setSecurityToken(string $securityToken): self
    {
        $this->securityToken = $securityToken;

        return $this;
    }

    /**
     * Renouveller le jeton de sécurité
     */
    public function renewToken() : self
    {
        // Création d'un jeton
        $token = bin2hex(random_bytes(16));

        return $this->setSecurityToken($token);
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

//    public function getCaptchaCode()
//    {
//        return $this->captchaCode;
//    }
//
//    public function setCaptchaCode($captchaCode)
//    {
//        $this->captchaCode = $captchaCode;
//    }

public function getName(): ?string
{
    return $this->name;
}

public function setName(?string $name): self
{
    $this->name = $name;

    return $this;
}

public function getLastName(): ?string
{
    return $this->last_name;
}

public function setLastName(?string $last_name): self
{
    $this->last_name = $last_name;

    return $this;
}

public function getBirthday(): ?\DateTimeInterface
{
    return $this->birthday;
}

public function setBirthday(?\DateTimeInterface $birthday): self
{
    $this->birthday = $birthday;

    return $this;
}

public function getNews(): ?bool
{
    return $this->news;
}

public function setNews(bool $news): self
{
    $this->news = $news;

    return $this;
}

public function getAgreeTerms(): ?bool
{
    return $this->agree_terms;
}

public function setAgreeTerms(?bool $agree_terms): self
{
    $this->agree_terms = $agree_terms;

    return $this;
}

public function getEnable(): ?bool
{
    return $this->enable;
}

public function setEnable(?bool $enable): self
{
    $this->enable = $enable;

    return $this;
}
}
