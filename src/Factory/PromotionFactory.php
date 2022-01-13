<?php

namespace App\Factory;

use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

use Doctrine\ORM\EntityManagerInterface;
use App\Controller\HomeController;
use DateTime;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @extends ModelFactory<Promotion>
 *
 * @method static Promotion|Proxy createOne(array $attributes = [])
 * @method static Promotion[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Promotion|Proxy find(object|array|mixed $criteria)
 * @method static Promotion|Proxy findOrCreate(array $attributes)
 * @method static Promotion|Proxy first(string $sortedField = 'id')
 * @method static Promotion|Proxy last(string $sortedField = 'id')
 * @method static Promotion|Proxy random(array $attributes = [])
 * @method static Promotion|Proxy randomOrCreate(array $attributes = [])
 * @method static Promotion[]|Proxy[] all()
 * @method static Promotion[]|Proxy[] findBy(array $attributes)
 * @method static Promotion[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Promotion[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PromotionRepository|RepositoryProxy repository()
 * @method Promotion|Proxy create(array|callable $attributes = [])
 */
final class PromotionFactory extends ModelFactory
{
    public function __construct(EntityManagerInterface $entityManager, HomeController $controller)
    {
        parent::__construct();
        $this->controller = $controller;
        $this->entityManager = $entityManager;

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {

        $depart = new DateTime();
        $nbrJour = rand(30, 365);
        $fin = new DateTime();
        $fin->setTimestamp($fin->getTimestamp() + ($nbrJour * 86400));
        
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nom' => self::faker()->company(),
            'description' => self::faker()->text(60),
            'documentPdf' => new BinaryFileResponse($this->controller->getParameter('kernel.project_dir')."/public/assets/doc.pdf"),
            'debut' => $depart,
            'fin' => $fin,
            'affichageDe' => $depart->setTimestamp($depart->getTimestamp() - (rand(7,60) * 86400)),
            'afficheJusque' => $fin
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Promotion $promotion): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Promotion::class;
    }
}
