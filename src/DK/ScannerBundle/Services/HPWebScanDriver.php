<?php
namespace DK\ScannerBundle\Services;

use DK\CoreBundle\Entity\Scan;
use Doctrine\Common\Persistence\ObjectManager;
use Httpful\Mime;
use Httpful\Request;

class HPWebScanDriver implements IScannerDriver {

    private $url;

    private $om;

    public function __construct($url, ObjectManager $om) {
        $this->url = $url;
        $this->om = $om;
    }

    private function registerNamespaces($xml) {
        $xml->registerXPathNamespace('j', 'http://www.hp.com/schemas/imaging/con/ledm/jobs/2009/04/30');
        $xml->registerXPathNamespace('sj', 'http://www.hp.com/schemas/imaging/con/cnx/scan/2008/08/19');
    }

    public function status() {
        $responseBody = Request::get($this->url."/Scan/Status")->send()->body;
        $xml = new \SimpleXMLElement($responseBody);

        $imageURL = "";

        if ($xml->ScannerState == "BusyWithScanJob") {
            $responseBody = Request::get($this->url."/Jobs/JobList")->send()->body;
            $jobsXml = new \SimpleXMLElement($responseBody);
            $this->registerNamespaces($jobsXml);

            $readyJob = $jobsXml->xpath("//j:Job[.//sj:ScanJob[.//sj:PageState = 'ReadyToUpload']]");
            if ($readyJob && sizeof($readyJob) == 1) {
                $scan = $this->createScan($readyJob[0]->ScanJob->PreScanPage->BinaryURL);
            }
        }

        return array(
            "isLoaded" => $xml->AdfState == "Loaded",
            "isIdle" => $xml->ScannerState == "Idle",
            "scannedId" => isset($scan) ? $scan->getId() : null
        );
    }

    private function createScan($imageURL) {
        $fromFile = $this->url.$imageURL;
        $toFile = uniqid("scan").".pdf";

        $lfile = fopen("scans/".$toFile, "w");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fromFile);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
        curl_setopt($ch, CURLOPT_FILE, $lfile);
        curl_exec($ch);
        fclose($lfile);
        curl_close($ch);

        $scan = new Scan();
        $scan->setFilename($toFile);
        $scan->setMimeType('application/pdf');
        $this->om->persist($scan);
        $this->om->flush();

        return $scan;
    }

    public function startScan() {
         $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<scan:ScanJob xmlns:scan="http://www.hp.com/schemas/imaging/con/cnx/scan/2008/08/19" xmlns:dd="http://www.hp.com/schemas/imaging/con/dictionaries/1.0/">
   <scan:XResolution>300</scan:XResolution>
   <scan:YResolution>300</scan:YResolution>
   <scan:XStart>0</scan:XStart>
   <scan:YStart>0</scan:YStart>
   <scan:Width>2480</scan:Width>
   <scan:Height>3508</scan:Height>
   <scan:Format>Pdf</scan:Format>
   <scan:CompressionQFactor>25</scan:CompressionQFactor>
   <scan:ColorSpace>Color</scan:ColorSpace>
   <scan:BitDepth>8</scan:BitDepth>
   <scan:InputSource>Adf</scan:InputSource>
   <scan:AdfOptions />
   <scan:GrayRendering>NTSC</scan:GrayRendering>
   <scan:ToneMap>
      <scan:Gamma>1000</scan:Gamma>
      <scan:Brightness>1000</scan:Brightness>
      <scan:Contrast>1000</scan:Contrast>
      <scan:Highlite>179</scan:Highlite>
      <scan:Shadow>25</scan:Shadow>
   </scan:ToneMap>
   <scan:ContentType>Document</scan:ContentType>
</scan:ScanJob>
XML;

        $responseBody = Request::post($this->url."/Scan/Jobs")
            ->body($xml)
            ->sendsXml()
            ->send();
    }

}