<?php

namespace App\Factory;

use App\Entity\Stage;
use App\Repository\StageRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

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
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nom' => self::faker()->text(),
            'description' => self::faker()->text(),
            'tarif' => self::faker()->text(),
            'infoComplementaires' => self::faker()->text(),
            'debut' => null, // TODO add DATETIME ORM type manually
            'fin' => null, // TODO add DATETIME ORM type manually
            'affichageDe' => null, // TODO add DATETIME ORM type manually
            'affichaqueJusque' => null, // TODO add DATETIME ORM type manually
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
