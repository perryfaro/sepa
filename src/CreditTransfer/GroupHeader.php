<?php
/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa\CreditTransfer;

use DateTime;

/**
 * Class GroupHeader
 *
 * @package silentgecko\Sepa\CreditTransfer
 */
class GroupHeader
{
    protected string $messageIdentification;

    protected string $initiatingPartyId;

    protected int $numberOfTransactions = 0;

    protected int $controlSum = 0;

    protected string $initiatingPartyName;

    protected DateTime $creationDateTime;

    /**
     * @param $messageIdentification
     * @param $initiatingPartyName
     */
    function __construct($messageIdentification = false, $initiatingPartyName = false)
    {
        $this->messageIdentification = $messageIdentification;
        $this->initiatingPartyName = $initiatingPartyName;
        $this->creationDateTime = new DateTime();
    }

    public function getControlSum() :int
    {
        return $this->controlSum;
    }

    public function getCreationDateTime() :DateTime
    {
        return $this->creationDateTime;
    }

    public function getInitiatingPartyId() :string
    {
        return $this->initiatingPartyId;
    }

    public function getInitiatingPartyName() :string
    {
        return $this->initiatingPartyName;
    }

    public function getNumberOfTransactions() :int
    {
        return $this->numberOfTransactions;
    }

    public function getMessageIdentification() :string
    {
        return $this->messageIdentification;
    }

    public function setControlSum(int $controlSum) :self
    {
        $this->controlSum = $controlSum;
        return $this;
    }

    public function setInitiatingPartyId(string $initiatingPartyId) :self
    {
        $this->initiatingPartyId = $initiatingPartyId;
        return $this;
    }

    public function setInitiatingPartyName(string $initiatingPartyName) :self
    {
        $this->initiatingPartyName = $initiatingPartyName;
        return $this;
    }

    public function setMessageIdentification(string $messageIdentification) :self
    {
        $this->messageIdentification = $messageIdentification;
        return $this;
    }

    public function setNumberOfTransactions(int $numberOfTransactions) :self
    {
        $this->numberOfTransactions = $numberOfTransactions;
        return $this;
    }

}
