<?php
namespace App\Entity;

/**
 * Description of JsonableTrait
 *
 * @author lpu8er
 */
trait JsonableTrait {
    public function jsonSerialize() {
        $returns = [];
        foreach(get_object_vars($this) as $k => $v) {
            if(is_object($v)) {
                if(method_exists($v, 'getId')) {
                    $returns[$k.'Id'] = $v->getId();
                }
            } else {
                $returns[$k] = $v;
            }
        }
        return $returns;
    }
}
