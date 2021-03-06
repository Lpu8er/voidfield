<?php
namespace App\Twig;

use App\Entity\User;
use App\Utils\TwigWrapper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension {
    public function getFilters()
    {
        return [
            new TwigFilter('duration', [$this, 'durationFilter',]),
            new TwigFilter('nformat', [$this, 'nformatFilter',]),
        ];
    }
    
    public function getFunctions() {
        return [
            new TwigFunction('param', [$this, 'paramFunction',]),
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
     * @param int $decimals
     * @param bool $prefixes
     * @return string
     */
    public function nformatFilter($number, int $decimals = 2, bool $prefixes = true) {
        return TwigWrapper::nformat($number, $prefixes, $decimals);
    }
    
    /**
     * 
     * @param User $user
     * @param string $key
     */
    public function paramFunction(User $user, string $key) {
        return $user->getParameter($key);
    }
}