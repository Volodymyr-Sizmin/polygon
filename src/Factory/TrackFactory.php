<?php

namespace App\Factory;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Track>
 *
 * @method static Track|Proxy createOne(array $attributes = [])
 * @method static Track[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Track|Proxy find(object|array|mixed $criteria)
 * @method static Track|Proxy findOrCreate(array $attributes)
 * @method static Track|Proxy first(string $sortedField = 'id')
 * @method static Track|Proxy last(string $sortedField = 'id')
 * @method static Track|Proxy random(array $attributes = [])
 * @method static Track|Proxy randomOrCreate(array $attributes = [])
 * @method static Track[]|Proxy[] all()
 * @method static Track[]|Proxy[] findBy(array $attributes)
 * @method static Track[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Track[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TrackRepository|RepositoryProxy repository()
 * @method Track|Proxy create(array|callable $attributes = [])
 */
final class TrackFactory extends ModelFactory
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
            'author' => self::faker()->name(),
            'title' => self::faker()->name(),
            'type' => self::faker()->email(),
            'genre' => self::faker()->text(),
            'track_path' => self::faker()->text(),
            'created_at' => \DateTimeImmutable::createFromMutable(self::faker()->datetime()),
            'updated_at' => \DateTimeImmutable::createFromMutable(self::faker()->datetime()),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Track $track) {})
        ;
    }

    protected static function getClass(): string
    {
        return Track::class;
    }
}
