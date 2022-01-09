<?php

namespace App\Factory;

use App\Entity\Internaute;
use App\Repository\InternauteRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Internaute>
 *
 * @method static Internaute|Proxy createOne(array $attributes = [])
 * @method static Internaute[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Internaute|Proxy find(object|array|mixed $criteria)
 * @method static Internaute|Proxy findOrCreate(array $attributes)
 * @method static Internaute|Proxy first(string $sortedField = 'id')
 * @method static Internaute|Proxy last(string $sortedField = 'id')
 * @method static Internaute|Proxy random(array $attributes = [])
 * @method static Internaute|Proxy randomOrCreate(array $attributes = [])
 * @method static Internaute[]|Proxy[] all()
 * @method static Internaute[]|Proxy[] findBy(array $attributes)
 * @method static Internaute[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Internaute[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static InternauteRepository|RepositoryProxy repository()
 * @method Internaute|Proxy create(array|callable $attributes = [])
 */
final class InternauteFactory extends ModelFactory
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
            'nom' => self::faker()->lastname(),
            'prenom' => self::faker()->firstname(),
            'newsletter' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Internaute $internaute): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Internaute::class;
    }
}
