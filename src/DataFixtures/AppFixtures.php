<?php

namespace App\DataFixtures;

use App\Entity\CategorieDeServices;
use App\Factory\PrestataireFactory;
use App\Factory\CategorieDeServicesFactory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PrestataireFactory::createMany(10);
        CategorieDeServicesFactory::createMany(10);

        $manager->flush();
    }
}
