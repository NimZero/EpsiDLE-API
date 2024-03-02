<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ApiResource()]
#[Get()]
#[GetCollection()]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Put(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[Assert\Positive()]
    #[ORM\Column]
    private ?int $height = null;

    #[Assert\LessThan('today')]
    #[ORM\Column]
    private ?\DateTimeImmutable $birthdate = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $hairColor = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $astrologicalSign = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $programmingLanguage = null;

    #[ORM\OneToMany(mappedBy: 'character', targetEntity: Anectode::class, orphanRemoval: true)]
    private Collection $anectodes;

    #[ORM\OneToMany(mappedBy: 'character', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->anectodes = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeImmutable $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getHairColor(): ?string
    {
        return $this->hairColor;
    }

    public function setHairColor(string $hairColor): static
    {
        $this->hairColor = $hairColor;

        return $this;
    }

    public function getAstrologicalSign(): ?string
    {
        return $this->astrologicalSign;
    }

    public function setAstrologicalSign(string $astrologicalSign): static
    {
        $this->astrologicalSign = $astrologicalSign;

        return $this;
    }

    public function getProgrammingLanguage(): ?string
    {
        return $this->programmingLanguage;
    }

    public function setProgrammingLanguage(string $programmingLanguage): static
    {
        $this->programmingLanguage = $programmingLanguage;

        return $this;
    }

    /**
     * @return Collection<int, Anectode>
     */
    public function getAnectodes(): Collection
    {
        return $this->anectodes;
    }

    public function addAnectode(Anectode $anectode): static
    {
        if (!$this->anectodes->contains($anectode)) {
            $this->anectodes->add($anectode);
            $anectode->setCharacter($this);
        }

        return $this;
    }

    public function removeAnectode(Anectode $anectode): static
    {
        if ($this->anectodes->removeElement($anectode)) {
            // set the owning side to null (unless already changed)
            if ($anectode->getCharacter() === $this) {
                $anectode->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setCharacter($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCharacter() === $this) {
                $image->setCharacter(null);
            }
        }

        return $this;
    }
}
