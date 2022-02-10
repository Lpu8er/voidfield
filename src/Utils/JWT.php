<?php
namespace App\Utils;

use App\Utils\Exceptions\JWTDecodeException;
use App\Utils\Exceptions\JWTValidityException;

/**
 * Description of JWT
 *
 * @author lpu8er
 */
class JWT {
    /**
     * Who issued the JWT
     */
    const CLAIM_ISS = 'iss';
    /**
     * Subject of the JWT
     */
    const CLAIM_SUB = 'sub';
    /**
     * Recipient of the JWT
     */
    const CLAIM_AUD = 'aud';
    /**
     * Expiration time (timestamp)
     */
    const CLAIM_EXP = 'exp';
    /**
     * Minimum time before that JWT can be used (timestamp)
     */
    const CLAIM_NBF = 'nbf';
    /**
     * When the JWT was issued (timestamp)
     */
    const CLAIM_IAT = 'iat';
    /**
     * Unique identifier for that JWT (avoid replaying)
     */
    const CLAIM_JTI = 'jti';
    
    const DEFAULT_ALGO = 'HS256';
    const DEFAULT_TYPE = 'JWT';
    
    /**
     * Decode and check JWT validity.
     * @param string $encoded
     * @param string $key
     * @param array $claims to be checked if provided
     * @return JWT|null
     */
    public static function decode(string $encoded, string $key, array $claims = []): ?self {
        $returns = null;
        $xs = explode('.', $encoded);
        if(3 === count($xs)) {
            $h = static::decodePart($xs[0]);
            $p = static::decodePart($xs[1]);
            if(empty($h)) {
                throw new JWTDecodeException('Invalid header (empty)');
            } elseif(empty($p)) {
                throw new JWTDecodeException('Invalid payload (empty)');
            } else {
                $returns = new static($key,
                        array_key_exists('typ', $h)? $h['typ']:null,
                        array_key_exists('alg', $h)? $h['alg']:null,
                        $p);
                $returns->checkValidity($xs[2], $claims);
            }
        } else {
            throw new JWTDecodeException('Invalid parts count');
        }
        return $returns;
    }
    
    /**
     * 
     * @param string $encoded
     * @return array|null
     */
    protected static function decodePart(string $encoded): ?array {
        return json_decode(base64_decode($encoded), true);
    }
    
    /**
     *
     * @var string 
     */
    private string $key = '';
    /**
     *
     * @var string 
     */
    protected string $type = 'JWT';
    /**
     *
     * @var string 
     */
    protected string $algo = 'HS256';
    /**
     *
     * @var string 
     */
    protected array $payload = [];
    
    /**
     * 
     * @param string $key
     * @param string|null $type
     * @param string|null $algo
     * @param array|null $payload
     */
    public function __construct(string $key, ?string $type = null, ?string $algo = null, ?array $payload = null) {
        $this->key = $key;
        $this->type = $type ?? static::DEFAULT_TYPE;
        $this->algo = $algo ?? static::DEFAULT_ALGO;
        $this->payload = $payload ?? [];
    }
    
    /**
     * 
     * @return string
     * 
     */
    protected function getEncodedHeader(): string {
        return base64_encode(json_encode(['alg' => $this->algo, 'typ' => $this->type,]));
    }
    
    /**
     * 
     * @return string
     */
    protected function getEncodedPayload(): string {
        return base64_encode(json_encode($this->payload));
    }
    
    /**
     * 
     * @return string
     */
    protected function sign(): string {
        $returns = '';
        $data = $this->getEncodedHeader().'.'.$this->getEncodedPayload();
        if('HS256' === $this->algo) {
            $returns = hash_hmac('sha256', $data, $this->key);
        }
        return $returns;
    }
    
    /**
     * Check JWT validity,
     * using claims and such,
     * and will issue exceptions if invalid.
     * @param string $sign
     * @param array $claims to be checked if provided
     * @return bool
     */
    private function checkValidity(string $sign, array $claims = []): bool {
        $returns = true;
        // sign ?
        $returns = ($this->sign() === $sign);
        if(!$returns) {
            throw new JWTValidityException('Invalid sign');
        }
        // claims
        $badClaims = [];
        foreach($claims as $ck => $cv) {
            $claimIsOk = true;
            if(in_array($ck, [static::CLAIM_ISS, static::CLAIM_SUB, static::CLAIM_JTI, static::CLAIM_IAT,])) {
                // identical
                $claimIsOk = ($this->hasClaim($ck) && ($cv === $this->getClaim($ck)));
            } elseif(in_array($ck, [static::CLAIM_AUD])) {
                // one into the ones authorized
                $claimIsOk = ($this->hasClaim($ck) && in_array($this->getClaim($ck, explode(',', $cv))));
            }
            if(!$claimIsOk) { $badClaims[] = $ck; }
            $returns &= $claimIsOk;
        }
        if(!$returns) {
            throw new JWTValidityException('Invalid claim(s) value(s) detected into '.implode(', ', $badClaims));
        }
        // if jwt contains some specific claims, check them too
        if($this->hasClaim(static::CLAIM_EXP)) {
            $returns &= (time() <= intval($this->getClaim(static::CLAIM_EXP)));
        }
        if(!$returns) {
            throw new JWTValidityException('Expired');
        }
        if($this->hasClaim(static::CLAIM_NBF)) {
            $returns &= (time() >= intval($this->getClaim(static::CLAIM_NBF)));
        }
        if(!$returns) {
            throw new JWTValidityException('Too early');
        }
        return $returns;
    }
    
    /**
     * 
     * @return string
     */
    public function encode(): string {
        $h = $this->getEncodedHeader();
        $p = $this->getEncodedPayload();
        $s = $this->sign();
        return implode('.', [$h, $p, $s]);
    }
    
    /**
     * 
     * @param string $claim
     * @param mixed $value
     * @return $this
     */
    public function setClaim(string $claim, $value): self {
        $this->payload[$claim] = $value;
        return $this;
    }
    
    /**
     * 
     * @param string $claim
     * @return bool
     */
    public function hasClaim(string $claim): bool {
        return array_key_exists($claim, $this->payload);
    }
    
    /**
     * 
     * @param string $claim
     * @return $this
     */
    public function removeClaim(string $claim): self {
        if($this->hasClaim($claim)) {
            unset($this->payload[$claim]);
        }
        return $this;
    }
    
    /**
     * 
     * @param string $claim
     * @param mixed $def default as null
     * @return mixed
     */
    public function getClaim(string $claim, $def = null) {
        return $this->hasClaim($claim)? $this->payload[$claim]:$def;
    }
}
