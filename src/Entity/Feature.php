<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"feature_read"}},
 *     "denormalization_context"={"groups"={"feature_write"}}
 * })
 * @ORM\Entity
 * @ORM\Table(name="feature")
 */
class Feature
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @Groups({"feature_read"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"feature_write", "feature_read"})
     */
    private $name;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     * @Groups({"feature_write", "feature_read"})
     */
    private $description;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill", inversedBy="features")
     * @Groups({"admin"})
     */
    private $skill;

    public function getId(): ?string
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }


}