<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method static     User|Proxy createOne(array $attributes = [])
 * @method static     User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static     User|Proxy find(object|array|mixed $criteria)
 * @method static     User|Proxy findOrCreate(array $attributes)
 * @method static     User|Proxy first(string $sortedField = 'id')
 * @method static     User|Proxy last(string $sortedField = 'id')
 * @method static     User|Proxy random(array $attributes = [])
 * @method static     User|Proxy randomOrCreate(array $attributes = [])
 * @method static     User[]|Proxy[] all()
 * @method static     User[]|Proxy[] findBy(array $attributes)
 * @method static     User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static     User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static     UserRepository|RepositoryProxy repository()
 * @method User|Proxy create(array|callable $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    /**
     * @var User
     */
    private $user;

    public function __construct(FileFactory $fileFactory, UserPasswordHasherInterface $encoder)
    {
        parent::__construct();

        $this->user = new User();
        $this->encoder = $encoder;
    }

    protected function getDefaults(): array
    {
        return [
            'roles' => ['ROLE_USER'],
            'password' => self::faker()->password(8, 32),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'userName' => self::faker()->userName(),
            'email' => self::faker()->unique()->safeEmail(),
            'isDeleted' => false,
            'playlists' => [],
        ];
    }

    protected function initialize(): self
    {
        return $this->afterInstantiate(function (User $user) {
            $user->setPassword($this->encoder->hashPassword($user, $user->getPassword()));
            $user->setProfilePhoto(FileFactory::createOne()->object());
        });
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
