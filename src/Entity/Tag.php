<?php

namespace App\Entity;

use App\Repository\TagRepository;
use App\Util\TimestampableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    use TimestampableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\ManyToMany(targetEntity: BlogPost::class, mappedBy: 'tags')]
    private Collection $blogPosts;


    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, BlogPost>
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts->add($blogPost);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): static
    {
        $this->blogPosts->removeElement($blogPost);

        return $this;
    }
}
