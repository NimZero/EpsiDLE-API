<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ]
)]
#[ApiResource(
    uriTemplate: '/characters/{characterId}/images',
    uriVariables: [
        'characterId' => new Link(fromClass: Character::class, toClass: self::class, fromProperty: 'character')
    ],
    operations: [
        new GetCollection(),
        new Post(),
    ]
)]
#[ApiResource(
    uriTemplate: '/characters/{characterId}/images/{id}',
    uriVariables: [
        'characterId' => new Link(fromClass: Character::class, toClass: self::class, fromProperty: 'character'),
        'id' => new Link(fromClass: self::class)
    ],
    operations: [
        new Get(),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
        new Patch(security: "is_granted('ROLE_ADMIN')"),
    ]
)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $character = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    public function setCharacter(?Character $character): static
    {
        $this->character = $character;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function __toString()
    {
        return 'Photo #' . $this->id;
    }

    #[ORM\PostRemove]
    public function postRemove(): void
    {
        $fs = new Filesystem();
        $fs->remove('/app/public/uploads/images/' . $this->path);
    }
}
