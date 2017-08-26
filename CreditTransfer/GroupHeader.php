<?php

/**
 * GroupHeader
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\CreditTransfer;

class GroupHeader {

    /**
     * @var string
     */
    protected $messageIdentification;

    /**
     * The initiating Party for this payment
     *
     * @var string
     */
    protected $initiatingPartyId;

    /**
     * @var integer
     */
    protected $numberOfTransactions = 0;

    /**
     * @var float
     */
    protected $controlSum = 0;

    /**
     * @var string
     */
    protected $initiatingPartyName;

    /**
     * @var string
     */
    protected $nifSuffix; // Company ID (mandatory in Spain)
	
    /**
     * @var \DateTime
     */
    protected $creationDateTime;

    /**
     * @param $messageIdentification
     * @param $initiatingPartyName
     */
    function __construct($messageIdentification = false, $initiatingPartyName = false) {
        $this->messageIdentification = $messageIdentification;
        $this->initiatingPartyName = $initiatingPartyName;
        $this->creationDateTime = new \DateTime();
    }

    /**
     * @return integer
     */
    public function getControlSum() {
        return floatval(round($this->controlSum,2));
    }

    /**
     * @return \DateTime
     */
    public function getCreationDateTime() {
        return $this->creationDateTime;
    }

    /**
     * @return string
     */
    public function getInitiatingPartyId() {
        return $this->initiatingPartyId;
    }

    /**
     * @return string
     */
    public function getInitiatingPartyName() {
        return $this->initiatingPartyName;
    }

    /**
     * @return integer
     */
    public function getNumberOfTransactions() {
        return $this->numberOfTransactions;
    }

    /**
     * @return string
     */
    public function getMessageIdentification() {
        return $this->messageIdentification;
    }

    /**
     * @return string
     */
	public function getNifSuffix() {
		return $this->nifSuffix;
	}

    /**
     * 
     * @param float $controlSum
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setControlSum($controlSum) {
        $this->controlSum = $controlSum;
        return $this;
    }

    /**
     * 
     * @param string $initiatingPartyId
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setInitiatingPartyId($initiatingPartyId) {
        $this->initiatingPartyId = $initiatingPartyId;
        return $this;
    }

    /**
     * 
     * @param string $initiatingPartyName
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setInitiatingPartyName($initiatingPartyName) {
        $this->initiatingPartyName = $initiatingPartyName;
        return $this;
    }

    /**
     * 
     * @param string $messageIdentification
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setMessageIdentification($messageIdentification) {
        $this->messageIdentification = $messageIdentification;
        return $this;
    }

    /**
     * 
     * @param integer $numberOfTransactions
     * @return \Sepa\CreditTransfer\GroupHeader
     */
    public function setNumberOfTransactions($numberOfTransactions) {
        $this->numberOfTransactions = $numberOfTransactions;
        return $this;
    }

    /**
     * 
     * @param string $nifSuffix  (Format XXXXXXXXXZZZ  being XXXXXXXXX nif ZZZ suffix)
     * @return \Sepa\CreditTransfer\GroupHeader
     */
	public function setNifSuffix($nifSuffix) {
        $this->nifSuffix = $nifSuffix;
        return $this;
	}
}
