<?php
namespace App\Utils;

/**
 *
 * @author lpu8er
 */
trait tFactory {
    /**
     * 
     * @return $this
     */
    public static function factory() {
        $cls = get_called_class();
        return new $cls;
    }
}
