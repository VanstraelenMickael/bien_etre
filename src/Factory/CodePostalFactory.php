<?php

namespace App\Factory;

use App\Entity\CodePostal;
use App\Repository\CodePostalRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CodePostal>
 *
 * @method static CodePostal|Proxy createOne(array $attributes = [])
 * @method static CodePostal[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CodePostal|Proxy find(object|array|mixed $criteria)
 * @method static CodePostal|Proxy findOrCreate(array $attributes)
 * @method static CodePostal|Proxy first(string $sortedField = 'id')
 * @method static CodePostal|Proxy last(string $sortedField = 'id')
 * @method static CodePostal|Proxy random(array $attributes = [])
 * @method static CodePostal|Proxy randomOrCreate(array $attributes = [])
 * @method static CodePostal[]|Proxy[] all()
 * @method static CodePostal[]|Proxy[] findBy(array $attributes)
 * @method static CodePostal[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CodePostal[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CodePostalRepository|RepositoryProxy repository()
 * @method CodePostal|Proxy create(array|callable $attributes = [])
 */
final class CodePostalFactory extends ModelFactory
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
            'codePostal' => self::faker()->postcode(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CodePostal $codePostal): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CodePostal::class;
    }
}
