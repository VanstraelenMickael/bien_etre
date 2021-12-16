<?php

namespace App\Factory;

use App\Entity\Prestataire;
use App\Repository\PrestataireRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Prestataire>
 *
 * @method static Prestataire|Proxy createOne(array $attributes = [])
 * @method static Prestataire[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Prestataire|Proxy find(object|array|mixed $criteria)
 * @method static Prestataire|Proxy findOrCreate(array $attributes)
 * @method static Prestataire|Proxy first(string $sortedField = 'id')
 * @method static Prestataire|Proxy last(string $sortedField = 'id')
 * @method static Prestataire|Proxy random(array $attributes = [])
 * @method static Prestataire|Proxy randomOrCreate(array $attributes = [])
 * @method static Prestataire[]|Proxy[] all()
 * @method static Prestataire[]|Proxy[] findBy(array $attributes)
 * @method static Prestataire[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Prestataire[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PrestataireRepository|RepositoryProxy repository()
 * @method Prestataire|Proxy create(array|callable $attributes = [])
 */
final class PrestataireFactory extends ModelFactory
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
            'nom' => self::faker()->firstName().substr(0,29),
            'siteweb' => self::faker()->url(),
            'numTel' => self::faker()->e164PhoneNumber(),
            'numTva' => self::faker()->swiftBicNumber(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Prestataire $prestataire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Prestataire::class;
    }
}
