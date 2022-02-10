<?php
namespace App\Controller;

use App\Entity\Skill;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of SkillController
 *
 * @author lpu8er
 * @Route("/skills")
 */
class SkillController extends InternalController {
    /**
     * @Route("/", name="skills")
     */
    public function skills(Request $request) {
        return $this->json($this->getDoctrine()->getRepository(Skill::class)->findByUsableOnCharacter(true));
    }
}
