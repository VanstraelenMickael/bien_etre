<?php

namespace App\Factory;

use App\Entity\CategorieDeServices;
use App\Repository\CategorieDeServicesRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CategorieDeServices>
 *
 * @method static CategorieDeServices|Proxy createOne(array $attributes = [])
 * @method static CategorieDeServices[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CategorieDeServices|Proxy find(object|array|mixed $criteria)
 * @method static CategorieDeServices|Proxy findOrCreate(array $attributes)
 * @method static CategorieDeServices|Proxy first(string $sortedField = 'id')
 * @method static CategorieDeServices|Proxy last(string $sortedField = 'id')
 * @method static CategorieDeServices|Proxy random(array $attributes = [])
 * @method static CategorieDeServices|Proxy randomOrCreate(array $attributes = [])
 * @method static CategorieDeServices[]|Proxy[] all()
 * @method static CategorieDeServices[]|Proxy[] findBy(array $attributes)
 * @method static CategorieDeServices[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CategorieDeServices[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CategorieDeServicesRepository|RepositoryProxy repository()
 * @method CategorieDeServices|Proxy create(array|callable $attributes = [])
 */
final class CategorieDeServicesFactory extends ModelFactory
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
            'nom' => substr(self::faker()->jobTitle(),0,29),
            'description' => self::faker()->text(10),
            'enAvant' => 0,
            'valide' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CategorieDeServices $categorieDeServices): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CategorieDeServices::class;
    }
}
