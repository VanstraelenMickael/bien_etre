<?php

namespace App\Factory;

use App\Entity\Commune;
use App\Repository\CommuneRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Commune>
 *
 * @method static Commune|Proxy createOne(array $attributes = [])
 * @method static Commune[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Commune|Proxy find(object|array|mixed $criteria)
 * @method static Commune|Proxy findOrCreate(array $attributes)
 * @method static Commune|Proxy first(string $sortedField = 'id')
 * @method static Commune|Proxy last(string $sortedField = 'id')
 * @method static Commune|Proxy random(array $attributes = [])
 * @method static Commune|Proxy randomOrCreate(array $attributes = [])
 * @method static Commune[]|Proxy[] all()
 * @method static Commune[]|Proxy[] findBy(array $attributes)
 * @method static Commune[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Commune[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CommuneRepository|RepositoryProxy repository()
 * @method Commune|Proxy create(array|callable $attributes = [])
 */
final class CommuneFactory extends ModelFactory
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
            'commune' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Commune $commune): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Commune::class;
    }
}
