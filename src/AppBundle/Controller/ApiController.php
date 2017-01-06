<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 * @Method("GET")
 */
class ApiController extends Controller
{
    /**
     * @Route("/fortunes", name="api_fortune_list")
     */
    public function indexAction()
    {
        $fortunes = $this->getDoctrine()
            ->getRepository('AppBundle:Fortune')
            ->findAll()
        ;

        return new JsonResponse($fortunes);
    }
}
