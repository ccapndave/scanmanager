<?php

namespace DK\ScannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScannerController extends Controller {

    /**
     * @Route("/status", options={"expose"=true})
     * @Method({"GET"})
     */
    public function statusAction() {
        return new JsonResponse($this->container->get("dk_scanner.driver")->status());
    }

    /**
     * @Route("/startScan", options={"expose"=true})
     * @Method({"GET","POST"})
     */
    public function startScanAction() {
        return new JsonResponse($this->container->get("dk_scanner.driver")->startScan());
    }

}
