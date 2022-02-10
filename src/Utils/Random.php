<?php
namespace App\Utils;

/**
 * Description of Random
 *
 * @author lpu8er
 */
class Random {
    use tFactory;
    
    /**
     * 
     * @param string $seed
     * @return string
     */
    public function pwd(string $seed): string {
        return sha1(uniqid(uniqid(md5($seed)), true));
    }
}
