<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeriesRepository")
 */
class Series
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2, nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $premiere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kind")
     */
    private $Kinds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="Series", orphanRemoval=true)
     */
    private $Comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episodes", mappedBy="Series", orphanRemoval=true)
     */
    private $Episodes;

    public function __construct()
    {
        $this->Kinds = new ArrayCollection();
        $this->Comments = new ArrayCollection();
        $this->Episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPremiere(): ?\DateTimeInterface
    {
        return $this->premiere;
    }

    public function setPremiere(\DateTimeInterface $premiere): self
    {
        $this->premiere = $premiere;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Kind[]
     */
    public function getKinds(): Collection
    {
        return $this->Kinds;
    }

    public function addKind(Kind $kind): self
    {
        if (!$this->Kinds->contains($kind)) {
            $this->Kinds[] = $kind;
        }

        return $this;
    }

    public function removeKind(Kind $kind): self
    {
        if ($this->Kinds->contains($kind)) {
            $this->Kinds->removeElement($kind);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->Comments->contains($comment)) {
            $this->Comments[] = $comment;
            $comment->setSeries($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->Comments->contains($comment)) {
            $this->Comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getSeries() === $this) {
                $comment->setSeries(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Episodes[]
     */
    public function getEpisodes(): Collection
    {
        return $this->Episodes;
    }

    public function addEpisode(Episodes $episode): self
    {
        if (!$this->Episodes->contains($episode)) {
            $this->Episodes[] = $episode;
            $episode->setSeries($this);
        }

        return $this;
    }

    public function removeEpisode(Episodes $episode): self
    {
        if ($this->Episodes->contains($episode)) {
            $this->Episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getSeries() === $this) {
                $episode->setSeries(null);
            }
        }

        return $this;
    }
}
