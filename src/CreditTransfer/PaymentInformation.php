<?php

/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa\CreditTransfer;

/**
 * Class PaymentInformation
 *
 * @package silentgecko\Sepa\CreditTransfer
 */
class PaymentInformation
{

    protected string $paymentInformationIdentification;

    protected string $paymentMethod = 'TRF';

    protected int $numberOfTransactions = 0;

    protected float $controlSum = 0;

    protected string $requestedExecutionDate;

    protected string $debtorName;

    protected string $debtorIban;

    protected string $debtorBic = 'NOTPROVIDED';

    protected array $payments = [];

    public function getControlSum(): float
    {
        return $this->controlSum;
    }

    public function setControlSum(float $controlSum): self
    {
        $this->controlSum = $controlSum;
        return $this;
    }

    public function getDebtorName(): string
    {
        return $this->debtorName;
    }

    public function setDebtorName(string $name): self
    {
        $this->debtorName = $name;
        return $this;
    }

    public function getDebtorIBAN(): string
    {
        return $this->debtorIban;
    }

    public function setDebtorIBAN(string $iban): self
    {
        $this->debtorIban = $iban;
        return $this;
    }

    public function getDebtorBIC(): string
    {
        return $this->debtorBic;
    }

    public function setDebtorBIC(string $bic): self
    {
        if ($bic !== '') {
            $this->debtorBic = $bic;
        }
        return $this;
    }

    public function getNumberOfTransactions(): int
    {
        return $this->numberOfTransactions;
    }

    public function setNumberOfTransactions(int $numberOfTransactions): self
    {
        $this->numberOfTransactions = $numberOfTransactions;
        return $this;
    }

    public function getPaymentInformationIdentification(): string
    {
        return $this->paymentInformationIdentification;
    }

    public function setPaymentInformationIdentification(string $paymentInformationIdentification): self
    {
        $this->paymentInformationIdentification = $paymentInformationIdentification;
        return $this;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function getRequestedExecutionDate(): string
    {
        return $this->requestedExecutionDate;
    }

    public function setRequestedExecutionDate(string $requestDate): self
    {
        $this->requestedExecutionDate = $requestDate;
        return $this;
    }

    /**
     *
     * @param array|Payment $payment
     *
     * @return PaymentInformation
     */
    public function addPayments($payment): self
    {
        if (is_array($payment)) {
            foreach ($payment as $transfer) {
                $this->payments[] = $transfer;
            }
        } else {
            $this->payments[] = $payment;
        }

        return $this;
    }
}
