<?php
namespace App\Utils;

use DateInterval;
use Exception;

/**
 * Description of TwigWrapper
 *
 * @author lpu8er
 */
abstract class TwigWrapper {
    /**
     * 
     * @param string $duration
     * @param bool $complex
     * @param bool $short
     * @return string
     */
    public static function duration(string $duration, bool $complex = false, bool $short = false): string {
        $str = 'Instantané';
        if(!empty($duration)) {
            try {
                $d = new DateInterval($duration);
                if(!empty($d)) {
                    $str = '';
                    if(!empty($d->days)) {
                        $str = $d->days.' jour';
                        if(1 < $d->days) { $str .= 's'; }
                    }
                    if($complex) {
                        if($short) {
                            if(0 < $d->h) {
                                $str .= strval($d->h).' heure';
                                if(1 < $d->h) { $str .= 's'; }
                            }
                            if(0 < $d->i) {
                                $str .= strval($d->i).' minute';
                                if(1 < $d->i) { $str .= 's'; }
                            }
                            if(0 < $d->s) {
                                $str .= strval($d->s).' seconde';
                                if(1 < $d->s) { $str .= 's'; }
                            }
                        } else {
                            if(0 < $d->h) {
                                $str .= strval($d->h).'h';
                            }
                            if(0 < $d->i) {
                                $str .= strval($d->i).'m';
                            }
                            if(0 < $d->s) {
                                $str .= strval($d->s).'s';
                            }
                        }
                    } else {
                        $str.= ' '.str_pad($d->h, 2, '0', STR_PAD_LEFT).':'.str_pad($d->i, 2, '0', STR_PAD_LEFT).':'.str_pad($d->s, 2, '0', STR_PAD_LEFT);
                    }
                }
            } catch (Exception $ex) { }
        }
        return trim($str);
    }
    
    /**
     * 
     * @param mixed $number
     * @return string
     */
    public static function nformat($number, bool $prefixes = true, int $decimals = 2) {
        $returns = '0';
        if(!empty($number)) {
            if($prefixes) {
                $returns = '';
                $sfn = sprintf('%F', $number);
                $tu = sprintf('%F', 1000**4); // T
                $bu = sprintf('%F', 1000**3); // B
                $mu = sprintf('%F', 1000**2); // M
                $ku = sprintf('%F', 1000); // k
                if(0 <= bccomp($sfn, $tu)) { // 1 000 000 000 000 => T
                    $returns.= floor(bcdiv($sfn, $tu)).'T';
                    $sfn = bcmod($sfn, $tu);
                }
                if(0 <= bccomp($sfn, $bu)) { // 1 000 000 000 => B
                    $returns.= floor(bcdiv($sfn, $bu)).'B';
                    $sfn = bcmod($sfn, $bu);
                }
                if(0 <= bccomp($sfn, $mu)) { // 1 000 000 => M
                    $returns.= floor(bcdiv($sfn, $mu)).'M';
                    $sfn = bcmod($sfn, $mu);
                }
                if(0 <= bccomp($sfn, $ku)) { // 1 000 => k
                    $returns.= floor(bcdiv($sfn, $ku)).'k';
                    $sfn = bcmod($sfn, $ku);
                }
                if(!empty($sfn)) {
                    $returns.= $sfn;
                }
            } else {
                $returns = number_format(floatval($number), $decimals, ',', ' ');
            }
        }
        return trim($returns);
    }
}
