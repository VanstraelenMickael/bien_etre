<?php

namespace App\DataFixtures;

use App\Factory\PrestataireFactory;
use App\Factory\CategorieDeServicesFactory;
use App\Factory\ImagesFactory;
use App\Factory\UserFactory;
use App\Factory\InternauteFactory;
use App\Factory\LocaliteFactory;
use App\Factory\CommuneFactory;
use App\Factory\CodePostalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CodePostalFactory::createMany(30);
        CommuneFactory::createMany(30);
        LocaliteFactory::createMany(30);

        CategorieDeServicesFactory::createMany(30);
        PrestataireFactory::createMany(50);
        InternauteFactory::createMany(50);
        
        $manager->flush();
    }
}
