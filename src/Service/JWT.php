<?php
namespace App\Service;

use App\Utils\JWT as JWTLib;

/**
 * Description of JWT
 *
 * @author lpu8er
 */
class JWT {
    protected string $key;
    protected string $issuer;
    
    public function __construct(string $key, string $issuer) {
        $this->key = $key;
        $this->issuer = $issuer;
    }
    
    public function decode(string $encoded): JWTLib {
        return JWTLib::decode(
                $encoded,
                $this->key,
                [
                    JWTLib::CLAIM_ISS => $this->issuer,
                ]
                );
    }
    
    public function generate(array $payload) {
        return new JWTLib($this->key,
                null,
                null,
                array_merge(
                        $payload, [
                            JWTLib::CLAIM_ISS => $this->issuer,
                        ]
                    )
                );
    }
}
