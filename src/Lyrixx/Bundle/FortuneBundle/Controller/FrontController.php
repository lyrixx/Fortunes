<?php

namespace Lyrixx\Bundle\FortuneBundle\Controller;

use Lyrixx\Bundle\FortuneBundle\Entity\Fortune;
use Lyrixx\Bundle\FortuneBundle\Entity\Search;
use Lyrixx\Bundle\FortuneBundle\Form\FortuneType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Template()
 * @Route("")
 * @Method("GET")
 */
class FrontController extends Controller
{
    /**
     * @Route("/", name="fortune_list", defaults={"orderBy"=null})
     * @Route("/top", name="fortune_list_top", defaults={"orderBy"="votes_desc"})
     * @Route("/flop", name="fortune_list_flop", defaults={"orderBy"="votes_asc"})
     */
    public function indexAction(Request $request)
    {
        $qb = $this->getDoctrine()
            ->getRepository('LyrixxFortuneBundle:Fortune')
            ->createQueryWithSearch(Search::createFromRequest($request))
        ;

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        try {
            $pager->setCurrentPage($request->query->getInt('page', 1));
        } catch (OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return ['pager' => $pager];
    }

    /**
     * @Route("/new", name="fortune_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fortune = new Fortune();
        $form = $this->createForm(FortuneType::class, $fortune);
        if ($form->handleRequest($request)->isValid() && $form->get('save')->isClicked()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fortune);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'The fortune has been created');

            return $this->redirect($this->generateUrl('fortune_list'));
        }

        return array(
            'form' => $form->createView(),
            'preview' => $form->isValid(),
        );
    }

    /**
     * @Route("/{id}", name="fortune_show")
     */
    public function showAction(Fortune $fortune)
    {
    }

    /**
     * @Route("/vote/{id}/{dir}/{token}",
     *     name="fortune_vote",
     *     requirements={
     *         "id"="\d+",
     *         "dir"="up|down",
     *     }
     * )
     */
    public function voteAction(Request $request, Fortune $fortune, $dir, $token)
    {
        if (!$this->isCsrfTokenValid('', $token)) {
            throw $this->createNotFoundException('Invalid CSRF.');
        }

        $fortune->vote($dir);
        $this->getDoctrine()->getManager()->flush();

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('votes' => $fortune->getVotes()));
        }

        return $this->redirect($this->generateUrl('fortune_list'));
    }
}
