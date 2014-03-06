<?php

namespace DK\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Scan
 *
 * @ORM\Entity()
 */
class Scan {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var date
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $notBill;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paid;

    /**
     * @var string
     * @ORM\Column(type="date", nullable=true)
     */
    private $paidOn;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $paidBy;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $letterFor;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $mimeType;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToMany(targetEntity="DK\CoreBundle\Entity\Tag")
     */
    private $tags;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Scan
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Scan
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Scan
     */
    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \DK\CoreBundle\Entity\Tag $tags
     * @return Scan
     */
    public function addTag(\DK\CoreBundle\Entity\Tag $tags) {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \DK\CoreBundle\Entity\Tag $tags
     */
    public function removeTag(\DK\CoreBundle\Entity\Tag $tags) {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     * @return Scan
     */
    public function setPaid($paid) {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid() {
        return $this->paid;
    }

    /**
     * Set paidOn
     *
     * @param \DateTime $paidOn
     * @return Scan
     */
    public function setPaidOn($paidOn) {
        $this->paidOn = $paidOn;

        return $this;
    }

    /**
     * Get paidOn
     *
     * @return \DateTime
     */
    public function getPaidOn() {
        return $this->paidOn;
    }

    /**
     * Set paidBy
     *
     * @param string $paidBy
     * @return Scan
     */
    public function setPaidBy($paidBy) {
        $this->paidBy = $paidBy;

        return $this;
    }

    /**
     * Get paidBy
     *
     * @return string
     */
    public function getPaidBy() {
        return $this->paidBy;
    }

    /**
     * Set letterFor
     *
     * @param string $letterFor
     * @return Scan
     */
    public function setLetterFor($letterFor) {
        $this->letterFor = $letterFor;

        return $this;
    }

    /**
     * Get letterFor
     *
     * @return string
     */
    public function getLetterFor() {
        return $this->letterFor;
    }


    /**
     * Set notBill
     *
     * @param boolean $notBill
     * @return Scan
     */
    public function setNotBill($notBill) {
        $this->notBill = $notBill;

        return $this;
    }

    /**
     * Get notBill
     *
     * @return boolean
     */
    public function getNotBill() {
        return $this->notBill;
    }
}
