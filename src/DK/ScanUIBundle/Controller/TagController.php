<?php

namespace DK\ScanUIBundle\Controller;

use DK\CoreBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tag controller.
 *
 * @Route("/tag")
 */
class TagController extends Controller {

    /**
     * @Route("/", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $name = $request->getContent();

        $em = $this->getDoctrine()->getManager();

        $tag = new Tag();
        $tag->setTag($name);
        $em->persist($tag);
        $em->flush();

        return new JsonResponse(array("id" => $tag->getId(), "tag" => $tag->getTag()));
    }

}
