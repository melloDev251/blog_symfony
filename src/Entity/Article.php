<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', length: 255)]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Your title must be at least {{ limit }} characters long',
        maxMessage: 'Your title cannot be longer than {{ limit }} characters',
    )]
    private $title;

    #[ORM\Column(type: 'text')]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'Your content must be at least {{ limit }} characters long',
        maxMessage: 'Your content cannot be longer than {{ limit }} characters',
    )]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Url(
        message: 'The url {{ value }} is not a valid url',
    )]
    private $image;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
