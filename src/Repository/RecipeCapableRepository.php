<?php
namespace App\Repository;

use App\Entity\Colony;
use App\Entity\iRecipeCapable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Description of RecipeCapableRepository
 *
 * @author lpu8er
 */
abstract class RecipeCapableRepository extends ServiceEntityRepository {
    protected $cacheResourcesBulk = null;
    
    /**
     * 
     * @param bool $ignoreCache
     * @return array
     */
    protected function reworkResourceBulk(Colony $colony, bool $ignoreCache = false): array {
        if($ignoreCache || (null === $this->cacheResourcesBulk)) {
            $this->cacheResourcesBulk = [];
            foreach($colony->getStocks() as $stock) {
                $this->cacheResourcesBulk[$stock->getResource()->getId()] = $stock->getStocks();
            }
        }
        return $this->cacheResourcesBulk;
    }
    
    /**
     * Check if colony has enough resources to build, returns an array of insufficient resources if not
     * @param iRecipeCapable $stuff
     * @param Colony $colony
     * @return array
     */
    protected function checkEnoughResources(iRecipeCapable $stuff, Colony $colony): array {
        $returns = [];
        // rework colony resource list, in order to optimize the search
        $resBulk = $this->reworkResourceBulk($colony);
        foreach($stuff->getRecipe() as $recipe) {
            $rid = $recipe->getResource()->getId();
            if(!array_key_exists($rid, $resBulk) || ($resBulk[$rid] < $recipe->getNb())) {
                $returns[$rid] = [
                    'actual' => empty($resBulk[$rid])? 0:$resBulk[$rid],
                    'need' => $recipe->getNb(),
                ];
            }
        }
        return $returns;
    }
}
