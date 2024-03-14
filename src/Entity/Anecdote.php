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
use App\Repository\AnecdoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AnecdoteRepository::class)]
#[ApiResource(
    uriTemplate: '/characters/{characterId}/anecdotes',
    uriVariables: [
        'characterId' => new Link(fromClass: Character::class, toClass: self::class, fromProperty: 'character')
    ],
    operations: [
        new GetCollection(),
        new Post(),
    ]
)]
#[ApiResource(
    uriTemplate: '/characters/{characterId}/anecdotes/{id}',
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
class Anecdote
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'anecdotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $character = null;

    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    public function __toString()
    {
        return 'Anecdote #' . $this->id;
    }

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
