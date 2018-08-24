<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\Technology;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Description of BuildingRepository
 *
 * @author lpu8er
 */
class BuildingRepository extends ServiceEntityRepository {
    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Building::class);
    }
    
    /**
     * Retrieve all buildings that can be built
     * @param Colony $colony
     * @return Building[]
     */
    public function visibleList(Colony $colony) {
        $bids = [];
        // first of all, retrieves a flat list of known technologies
        $technologies = $this->getEntityManager()->getRepository(Technology::class)->retrieveFlatList($colony->getOwner());
        // we'll go deep in native query in order to optimize that shit
        $techiesClause = ''; // extreme case, but eh
        if(!empty($technologies)) {
            $techiesClause = ' and ubc.need_id not in('.implode(', ', array_map('intval', $technologies)).')';
        }
        
        $q = <<<EOQ
select b.id
from buildings b
left join buildingconds ubc on ubc.target_id=b.id {$techiesClause}
left join colonybuildings cb on cb.building_id=b.replacing_id and cb.colony_id=:c
where ubc.target_id is null
    and (b.replacing_id is null or cb.colony_id is not null)
EOQ;
        
        $sql = $this->getEntityManager()->getConnection(); // we got an usual PDO object there
        $stmt = $sql->prepare($q);
        $stmt->bindValue('c', $colony->getId());
        $stmt->execute();
        $ls = $stmt->fetchAll($sql::FETCH_ASSOC); // we have a small subset of results that we need to format
        foreach($ls as $l) {
            $bids[$l['id']] = $l['id']; // avoid duplicates
        }
        
        // here we go to grab doctrine objects
        $qb = $this->createQueryBuilder();
        $qb->select('b');
        $qb->where($qb->expr()->in('b.id', $bids));
        return $qb->getQuery()->getResult(); // hydrate with buildings : we're good
    }
}
