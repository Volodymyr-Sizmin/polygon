<?php

namespace App\Repository;

use App\Entity\PlaylistsTracks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaylistsTracks|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaylistsTracks|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistsTracks[]    findAll()
 * @method PlaylistsTracks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistsTracksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistsTracks::class);
    }

    public function existPlaylistsTracks($playlist_id, $track_id)
    {
         $qb = $this->createQueryBuilder('p')
             ->where('p.playlist_id = :playlist_id')
             ->andWhere('p.track_id = :track_id')
             ->setParameters(new ArrayCollection(array(
                 new Parameter('playlist_id', $playlist_id),
                 new Parameter('track_id', $track_id)
             )));


        $query = $qb->getQuery();

        return $query->execute();
    }
}
