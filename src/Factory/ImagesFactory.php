<?php

namespace App\Factory;

use App\Entity\Images;
use App\Repository\ImagesRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\HomeController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ModelFactory<Images>
 *
 * @method static Images|Proxy createOne(array $attributes = [])
 * @method static Images[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Images|Proxy find(object|array|mixed $criteria)
 * @method static Images|Proxy findOrCreate(array $attributes)
 * @method static Images|Proxy first(string $sortedField = 'id')
 * @method static Images|Proxy last(string $sortedField = 'id')
 * @method static Images|Proxy random(array $attributes = [])
 * @method static Images|Proxy randomOrCreate(array $attributes = [])
 * @method static Images[]|Proxy[] all()
 * @method static Images[]|Proxy[] findBy(array $attributes)
 * @method static Images[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Images[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ImagesRepository|RepositoryProxy repository()
 * @method Images|Proxy create(array|callable $attributes = [])
 */
final class ImagesFactory extends ModelFactory
{
    public function __construct(HomeController $controller, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->controller = $controller;
        $this->entityManager = $entityManager;
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $repository = $this->entityManager->getRepository(Images::class);
        $image = $repository->findLast();
        if(is_array($image) && !empty($image)){
            $lastId = $image[0]->getId()+1;
        }else{
            $lastId = 1;
        }
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'ordre' => $lastId,
            'image' => new BinaryFileResponse($this->controller->getParameter('kernel.project_dir')."/public/img/blob.png")
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Images $images): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Images::class;
    }
}
