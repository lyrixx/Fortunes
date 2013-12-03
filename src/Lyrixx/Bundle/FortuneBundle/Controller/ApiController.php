<?php

namespace Lyrixx\Bundle\FortuneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Template()
 * @Route("/api", requirements={"_method"="GET"})
 */
class ApiController extends Controller
{
    /**
     * @Route("/fortunes", name="api_fortune_list")
     */
    public function indexAction()
    {
        $fortunes = $this->getDoctrine()
            ->getRepository('LyrixxFortuneBundle:Fortune')
            ->findAll()
        ;

        return new JsonResponse($fortunes);
    }
}
