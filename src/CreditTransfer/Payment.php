<?php

/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa\CreditTransfer;

/**
 * Class Payment
 *
 * @package silentgecko\Sepa\CreditTransfer
 */
class Payment
{
    protected string $amount;

    protected string $creditorName;

    protected string $creditorIban;

    protected string $creditorBic = 'NOTPROVIDED';

    protected string $currency = 'EUR';

    protected string $endToEndId;

    protected string $remittanceInformation;

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCreditorName(): string
    {
        return $this->creditorName;
    }

    public function setCreditorName(string $name): self
    {
        $this->creditorName = $name;
        return $this;
    }

    public function getCreditorIBAN(): string
    {
        return $this->creditorIban;
    }

    public function setCreditorIBAN(string $iban): self
    {
        $this->creditorIban = $iban;
        return $this;
    }

    public function getCreditorBIC(): string
    {
        return $this->creditorBic;
    }

    public function setCreditorBIC(string $bic): self
    {
        if ($bic !== null && $bic !== '') {
            $this->creditorBic = $bic;
        }
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getEndToEndId(): string
    {
        return $this->endToEndId;
    }

    public function setEndToEndId(string $endToEndId): self
    {
        $this->endToEndId = $endToEndId;
        return $this;
    }

    public function getRemittanceInformation(): string
    {
        return $this->remittanceInformation;
    }

    public function setRemittanceInformation(string $remittanceInformation): self
    {
        $this->remittanceInformation = $remittanceInformation;
        return $this;
    }
}
