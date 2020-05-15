<?php
namespace App\Utils;

use App\Entity\Building;
use App\Entity\Colony;

/**
 * Description of Toolbox
 *
 * @author lpu8er
 */
class Toolbox {
    /**
     * Deep-copy an object
     * Both obects HAS to have for each getter of $source, a setter of $target
     * @param object $source
     * @param object $target
     * @return object
     */
    public static function shallow(object $source, object $target): object {
        $sourceMethods = get_class_methods($source);
        foreach($sourceMethods as $mn) {
            if('get' === substr($mn, 0, 3)) { // getter
                $tm = substr_replace($mn, 'set', 0, 3);
                if(method_exists($target, $tm)) {
                    $target->{$tm}($source->{$mn}());
                }
            }
        }
        return $target;
    }
    
    /**
     * 
     * @return array
     */
    public static function getCtypes(): array {
        return [
            Colony::CTYPE_WATER => Building::RESTRICT_LAND,
            Colony::CTYPE_WATER => Building::RESTRICT_WATER,
            Colony::CTYPE_AIR => Building::RESTRICT_ATMOSPHERIC,
            Colony::CTYPE_SPACE => Building::RESTRICT_ORBITAL,
        ];
    }
    
    /**
     * 
     * @param string $ctype
     * @return int
     */
    public static function getRestrictedBits(string $ctype): int {
        $mp = static::getCtypes();
        return array_key_exists($ctype, $mp)? $mp[$ctype]:0;
    }
    
    /**
     * 
     * @return string[]
     */
    public static function sqlCtypes(): array {
        $returns = [];
        $mp = static::getCtypes();
        foreach($mp as $c => $r) {
            $returns[] = "when '".preg_replace('`[^a-z]`', '', $c)."' then ".strval(intval($r));
        }
        return $returns;
    }
}
