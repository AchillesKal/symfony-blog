<?php

namespace App\Entity;

use App\Repository\TagRepository;
use App\Util\TimestampableEntityTrait;
use App\Validator\LimitMenuTags;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

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

    #[ORM\Column(length: 255, unique: true)]
    #[Slug(fields: ['title'])]
    private string $slug;

    #[ORM\ManyToMany(targetEntity: BlogPost::class, mappedBy: 'tags')]
    private Collection $blogPosts;

    #[ORM\Column]
    #[LimitMenuTags]
    private bool $isMenu = false;

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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function isMenu(): bool
    {
        return $this->isMenu;
    }

    public function setIsMenu(bool $isMenu): static
    {
        $this->isMenu = $isMenu;

        return $this;
    }
}
