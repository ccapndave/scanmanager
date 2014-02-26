<?php
namespace DK\ScannerBundle\Services;

interface IScannerDriver {

    /**
     * Status returns an object:
     *  - isIdle
     *  - isLoaded
     *
     * @return array
     */
    function status();

    /**
     * Start scanning a document
     */
    function startScan();

}