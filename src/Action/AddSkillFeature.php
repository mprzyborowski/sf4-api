<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\Feature;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AddSkillFeature
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function __invoke(Skill $skill)
    {


        $feature = new Feature();
        $feature
            ->setName("name")
            ->setDescription("description");

        $skill->addFeature($feature);

        $manager = $this->managerRegistry->getManagerForClass(Skill::class);
        $manager->persist($skill);
        $manager->flush();

        return $skill;
    }


}