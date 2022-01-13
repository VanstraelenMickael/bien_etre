<?php

namespace App\Factory;

use App\Entity\Stage;
use App\Repository\StageRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use DateTime;

/**
 * @extends ModelFactory<Stage>
 *
 * @method static Stage|Proxy createOne(array $attributes = [])
 * @method static Stage[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Stage|Proxy find(object|array|mixed $criteria)
 * @method static Stage|Proxy findOrCreate(array $attributes)
 * @method static Stage|Proxy first(string $sortedField = 'id')
 * @method static Stage|Proxy last(string $sortedField = 'id')
 * @method static Stage|Proxy random(array $attributes = [])
 * @method static Stage|Proxy randomOrCreate(array $attributes = [])
 * @method static Stage[]|Proxy[] all()
 * @method static Stage[]|Proxy[] findBy(array $attributes)
 * @method static Stage[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Stage[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static StageRepository|RepositoryProxy repository()
 * @method Stage|Proxy create(array|callable $attributes = [])
 */
final class StageFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $depart = new DateTime();
        $nbrJour = rand(30, 365);
        $fin = new DateTime();
        $fin->setTimestamp($fin->getTimestamp() + ($nbrJour * 86400));
        $debutAffichage = new DateTime();
        
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nom' => self::faker()->company(),
            'description' => self::faker()->text(60),
            'tarif' => self::faker()->numberBetween(10, 50),
            'infoComplementaires' => self::faker()->text(30),
            'debut' => $depart,
            'fin' => $fin,
            'affichageDe' => $debutAffichage->setTimestamp($depart->getTimestamp() - (rand(7,60) * 86400)),
            'afficheJusque' => $fin
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Stage $stage): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Stage::class;
    }
}
