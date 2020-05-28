<?php
namespace App\Repository;

use App\Entity\User;
use App\Entity\WsToken;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of WsTokenRepository
 *
 * @author lpu8er
 */
class WsTokenRepository extends ServiceEntityRepository {
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, WsToken::class);
    }
    
    /**
     * Generate a new token that's not yet used
     * @return string
     */
    protected function generateNewToken(): string {
        $returns = null;
        $mx = 100; // after 100 tries, fix a token even if already used
        $cnt = 0;
        do {
            $returns = uniqid(md5(uniqid()), true);
            $w = null;
            try {
                $w = $this->findOneBy([
                    'token' => $returns,
                ]);
            } catch(Exception $e) {
                $w = null;
            }
        } while(!empty($w) && (++$cnt < $mx));
        return $returns;
    }
    
    /**
     * Auth an user against a provided token if any. If not, register a new token.
     * @param Request $request
     * @param User $user
     * @return WsToken|null
     */
    public function auth(Request $request, User $user): ?WsToken {
        $wst = null;
        $ip = $request->getClientIp();
        if($request->request->has('token')) {
            $token = $request->request->get('token');
            $wst = $this->findOneBy([
                'token' => $token,
                'ip' => $ip,
                'status' => WsToken::STATUS_READY,
            ]);
            if(!empty($wst)) { // token is valid : don't do thing, auth have to be done against a WS
                // @TODO
            } else { // no valid token but still asked for ? invalidate any linked to that IP / token
                // @TODO
            }
        } else { // no token yet : generate one
            $wst = new WsToken;
            $wst->setToken($this->generateNewToken());
            $wst->setDateGen(new DateTime);
            $wst->setDateExpire($wst->getDateGen()->add(new DateInterval('P1H')));
            $wst->setIp($ip);
            $wst->setPlayer($user);
            $wst->setStatus(WsToken::STATUS_READY);
        }
        return $wst;
    }
}
