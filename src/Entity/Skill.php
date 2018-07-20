<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"skill_read", "feature_read"}},
 *     "denormalization_context"={"groups"={"skill_write", "feature_write"}}
 * })
 * @ORM\Entity
 * @ORM\Table(name="skill")
 * @ApiFilter(SearchFilter::class, properties={"career.id": "exact"})
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @Groups({"skill_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"skill_write", "skill_read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Career", inversedBy="skills")
     */
    private $career;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="parent")
     * @Groups({"skill_write", "skill_read"})
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feature", mappedBy="skill")
     * @Groups({"skill_write", "skill_read"})
     */
    private $features;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCareer(): ?Career
    {
        return $this->career;
    }

    public function setCareer(?Career $career): self
    {
        $this->career = $career;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Skill $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Skill $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Feature[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
            $feature->setSkill($this);
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
            // set the owning side to null (unless already changed)
            if ($feature->getSkill() === $this) {
                $feature->setSkill(null);
            }
        }

        return $this;
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

}