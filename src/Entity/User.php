<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotNull
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotNull
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Email(
     *     message = "The email '{{  }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  *  * @Assert\Length(
     *      min = 8,
     *      max = 20,
     *      minMessage = "Your password must be at least {{ 8 }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ 20 }} characters"
     * )
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Guide::class, inversedBy="users")
     */
    private $guide;

    public function __construct()
    {
        $this->guide = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Guide>
     */
    public function getGuide(): Collection
    {
        return $this->guide;
    }

    public function addGuide(Guide $guide): self
    {
        if (!$this->guide->contains($guide)) {
            $this->guide[] = $guide;
        }

        return $this;
    }

    public function removeGuide(Guide $guide): self
    {
        $this->guide->removeElement($guide);

        return $this;
    }
}
