<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Feature;
use App\Entity\Skill;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route(name="add_skill_feature", path="/api/skills/{id}/feature",
     *      defaults={
     *         "_api_resource_class"=Skill::class,
     *         "_api_item_operation_name"="add_feature"
     *     }
     * )
     * @Method({"POST"})
     * @param Skill $skill
     * @return Skill
     */
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