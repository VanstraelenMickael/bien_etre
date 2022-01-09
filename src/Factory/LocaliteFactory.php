<?php

namespace App\Factory;

use App\Entity\Localite;
use App\Repository\LocaliteRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Localite>
 *
 * @method static Localite|Proxy createOne(array $attributes = [])
 * @method static Localite[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Localite|Proxy find(object|array|mixed $criteria)
 * @method static Localite|Proxy findOrCreate(array $attributes)
 * @method static Localite|Proxy first(string $sortedField = 'id')
 * @method static Localite|Proxy last(string $sortedField = 'id')
 * @method static Localite|Proxy random(array $attributes = [])
 * @method static Localite|Proxy randomOrCreate(array $attributes = [])
 * @method static Localite[]|Proxy[] all()
 * @method static Localite[]|Proxy[] findBy(array $attributes)
 * @method static Localite[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Localite[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LocaliteRepository|RepositoryProxy repository()
 * @method Localite|Proxy create(array|callable $attributes = [])
 */
final class LocaliteFactory extends ModelFactory
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
            'localite' => self::faker()->city(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Localite $localite): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Localite::class;
    }
}
