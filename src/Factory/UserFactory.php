<?php

namespace App\Factory;

use App\Entity\User;
use App\Entity\Internaute;
use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Localite;

use App\Repository\UserRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use DateTime;

use App\Factory\CodePostalFactory;
use App\Factory\CommuneFactory;
use App\Factory\LocaliteFactory;
use App\Factory\InternauteFactory;

use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ModelFactory<User>
 *
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static User|Proxy find(object|array|mixed $criteria)
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy first(string $sortedField = 'id')
 * @method static User|Proxy last(string $sortedField = 'id')
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create(array|callable $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager)
    {
        $this -> passwordHasher = $passwordHasher;
        $this -> manager = $manager;
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $internaute = InternauteFactory::createOne();
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->email(),
            'roles' => [],
            'adresse' => self::faker()->streetName(),
            'adresseNum' => self::faker()->buildingNumber(),
            'inscription' => new DateTime(),
            'typeUtilisateur' => 'Prest',
            'internaute' => $internaute
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            ->afterInstantiate(function(User $user) {
                $repository = $this->manager->getRepository(CodePostal::class);
                $max = $repository->findLast();
                $max = $max[0]->getId();
                $cp = $repository->find(rand($max-29,$max));

                $repository = $this->manager->getRepository(Commune::class);
                $max = $repository->findLast();
                $max = $max[0]->getId();
                $cm = $repository->find(rand($max-29,$max));

                $repository = $this->manager->getRepository(Localite::class);
                $max = $repository->findLast();
                $max = $max[0]->getId();
                $lo = $repository->find(rand($max-29,$max));

                $user->setPassword(
                    $this->passwordHasher->hashpassword($user, "test"),
                );
                $user->setCodePostal($cp);
                $user->setCommune($cm);
                $user->setLocalite($lo);
                $internaute = $user->getInternaute();
                $internaute->setUser($user);
                //$this->passwordHasher->hashpassword($this->user, "test"),
            })
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
