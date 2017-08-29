<?php

/**
 * Payment
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\CreditTransfer;

class Payment {

    /**
     *
     * @var string
     */
    protected $amount;

    /**
     *
     * @var string 
     */
    protected $creditorName;


    /**
     *
     * @var string 
     */
    protected $creditorCountry;

    /**
     *
     * @var string 
     */
    protected $creditorAddress;

    /**
     *
     * @var string 
     */
    protected $creditorAddress2;

    /**
     *
     * @var string 
     */
    protected $creditorIBAN;

    /**
     *
     * @var string 
     */
    protected $creditorBIC = 'NOTPROVIDED';
    
    /**
     *
     * @var string
     */
    protected $currency = 'EUR';

    /**
     *
     * @var string
     */
    protected $endToEndId;

    /**
     *
     * @var string
     */
    protected $remittanceInformation;

    /**
	 *
	 * @var string
	 */
    protected $ctgyPurp = false;

    /**
     *
     * @var bool
     */
	protected $isSepa = true;

    /**
     * 
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * 
     * @return string
     */
    public function getCreditorName() {
        return $this->creditorName;
    }

    /**
     * 
     * @return string
     */
	public function getCreditorCountry() {
        return $this->creditorCountry;
	}

    /**
     * 
     * @return string
     */
	public function getCreditorAddress() {
        return $this->creditorAddress;
	}

    /**
     * 
     * @return string
     */
	public function getCreditorAddress2() {
        return $this->creditorAddress2;
	}

    /**
     * 
     * @return string
     */
    public function getCreditorIBAN() {
        return $this->creditorIBAN;
    }

    /**
     * 
     * @return string
     */
    public function getCreditorBIC() {
        return $this->creditorBIC;
    }
    
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * 
     * @return string
     */
    public function getEndToEndId() {
        return $this->endToEndId;
    }

    /**
     * 
     * @return string
     */
    public function getRemittanceInformation() {
        return $this->remittanceInformation;
    }

	/**
	 * @return string
	 */
	public function getCtgyPurp() {
		return $this->ctgyPurp;
	}
	
	/**
	 * @return bool
	 */
	public function getIsSepa() {
		return $this->isSepa;
	}
	
    /**
     * 
     * @param string $amount
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorName($name) {
        $this->creditorName = $name;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\Payment
     */
	public function setCreditorCountry($country) {
        $this->creditorCountry = $country;
        return $this;
	}

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\Payment
     */
	public function setCreditorAddress($address) {
        $this->creditorAddress = $address;
        return $this;
	}

    /**
     * 
     * @param string $name
     * @return \Sepa\CreditTransfer\Payment
     */
	public function setCreditorAddress2($address2) {
        $this->creditorAddress2 = $address2;
        return $this;
	}
	
	
    /**
     * 
     * @param string $IBAN
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorIBAN($IBAN) {
        $this->creditorIBAN = $IBAN;
        return $this;
    }

    /**
     * 
     * @param string $BIC
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setCreditorBIC($BIC) {
        $this->creditorBIC = $BIC;
        return $this;
    }
    
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * 
     * @param string $endToEndId
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setEndToEndId($endToEndId) {
        $this->endToEndId = $endToEndId;
        return $this;
    }


    /**
     * 
     * @param string $remittanceInformation
     * @return \Sepa\CreditTransfer\Payment
     */
    public function setRemittanceInformation($remittanceInformation) {
        $this->remittanceInformation = $remittanceInformation;
        return $this;
    }

    /**
     * 
     * @param string $ctgyPurp
     * @return \Sepa\CreditTransfer\Payment
     *
     * Valid $ctgyPurp values:
     *
     * INTC IntraCompanyPayment
     * CORT TradeSettlementPayment
     * SALA SalaryPayment
     * TREA TreasuryPayment
     * CASH CashManagementTransfer
     * DIVI Dividend
     * GOVT GovernmentPayment
     * INTE Interest
     * LOAN Loan
     * PENS PensionPayment
     * SECU Securities
     * SSBE SocialSecurityBenefit
     * TAXS TaxPayment
     * VATX ValueAddedTaxPayment
     * SUPP SupplierPayment
     * HEDG Hedging
     * TRAD Trade
     * WHLD WithHolding
     */
	public function setCtgyPurp($ctgyPurp) {
		$this->ctgyPurp = $ctgyPurp;
		return $this;
	}

    /**
     * 
     * @param bool $isSepa
     * @return \Sepa\CreditTransfer\Payment
     */	
	public function setIsSepa($isSepa) {
		$this->isSepa = $isSepa;
		return $this;
	}
	
}
