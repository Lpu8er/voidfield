<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {
    public function getFilters()
    {
        return [
            new TwigFilter('duration', [$this, 'durationFilter',]),
            new TwigFilter('nformat', [$this, 'nformatFilter',]),
        ];
    }
    
    /**
     * 
     * @param string $duration
     * @return string
     */
    public function durationFilter($duration) {
        $str = 'Instantané';
        if(!empty($duration)) {
            try {
                $d = new \DateInterval($duration);
                if(!empty($d)) {
                    $str = '';
                    if(!empty($d->days)) {
                        $str = $d->days.' jour';
                        if(1 < $d->days) { $str .= 's'; }
                    }
                    $str.= ' '.str_pad($d->h, 2, '0', STR_PAD_LEFT).':'.str_pad($d->i, 2, '0', STR_PAD_LEFT).':'.str_pad($d->s, 2, '0', STR_PAD_LEFT);
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
    public function nformatFilter($number) {
        $returns = '0';
        if(!empty($number)) {
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
        }
        return trim($returns);
    }
}