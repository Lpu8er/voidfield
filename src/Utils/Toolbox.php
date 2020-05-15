<?php
namespace App\Utils;

/**
 * Description of Toolbox
 *
 * @author lpu8er
 */
class Toolbox {
    /**
     * Deep-copy an object
     * Both obects HAS to have for each getter of $source, a setter of $target
     * @param \stdClass $source
     * @param \stdClass $target
     * @return \stdClass
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
}
