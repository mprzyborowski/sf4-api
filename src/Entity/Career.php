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
 * @ORM\Entity
 * @ORM\Table(name="career")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"career_read", "skill_read", "feature_read"}},
 *     "denormalization_context"={"groups"={"career_write", "skill_write", "feature_write"}}
 * })
 * @ApiFilter(SearchFilter::class, properties={"field": "exact"})
 */
class Career
{

    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     * @Groups({"career_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"career_write", "career_read"})
     */
    private $field;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="career", cascade={"persist"})
     * @Groups({"career_write", "career_read"})
     */
    private $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setCareer($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getCareer() === $this) {
                $skill->setCareer(null);
            }
        }

        return $this;
    }


}