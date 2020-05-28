<?php
namespace App\Twig;

use App\Utils\TwigWrapper;
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
     * @param bool $complex
     * @param bool $short
     * @return string
     */
    public function durationFilter(string $duration, bool $complex = false, bool $short = false): string {
        return TwigWrapper::duration($duration, $complex, $short);
    }
    
    /**
     * 
     * @param mixed $number
     * @return string
     */
    public function nformatFilter($number) {
        return TwigWrapper::nformat($number);
    }
}