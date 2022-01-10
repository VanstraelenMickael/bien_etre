<?php

namespace App\DataFixtures;

use App\Factory\PrestataireFactory;
use App\Factory\CategorieDeServicesFactory;
use App\Factory\ImagesFactory;
use App\Factory\UserFactory;
use App\Factory\InternauteFactory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategorieDeServicesFactory::createMany(30);
        ImagesFactory::createMany(200);
        InternauteFactory::createMany(200);
        UserFactory::createMany(200);
        PrestataireFactory::createMany(200);
        
        $manager->flush();
    }
}
