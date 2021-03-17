<?php
/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa;

use DOMDocument;
use silentgecko\Sepa\Builder\CreditTransfer as Builder;
use silentgecko\Sepa\Builder\SepaSctException;
use silentgecko\Sepa\CreditTransfer\GroupHeader;
use silentgecko\Sepa\CreditTransfer\PaymentInformation;

/**
 * Class CreditTransfer
 *
 * @package silentgecko\Sepa
 */
class CreditTransfer
{

    protected ?GroupHeader $groupHeader = null;

    protected ?PaymentInformation $paymentInformation = null;

    public function setGroupHeader(GroupHeader $groupHeader) :self
    {
        $this->groupHeader = $groupHeader;
        return $this;
    }

    public function setPaymentInformation(PaymentInformation $paymentInformation) :self
    {
        $this->paymentInformation = $paymentInformation;
        return $this;
    }

    public function validate(string $xml, string $painformat = 'pain.001.001.03') :bool
    {
        $reader = new DOMDocument();
        $reader->loadXML($xml);
        if ($reader->schemaValidate(__DIR__ . '/../xsd/' . $painformat . '.xsd')) {
            return true;
        }
        return false;
    }

    public function xml(string $painformat = 'pain.001.001.03') :string
    {
        if ($this->groupHeader === null) {
            throw new SepaSctException('GroupHeader cannot be empty.');
        }

        if ($this->paymentInformation === null) {
            throw new SepaSctException('PaymentInformation cannot be empty.');
        }

        $build = new Builder($painformat);
        $build->appendGroupHeader($this->groupHeader);
        $build->appendPaymentInformation($this->paymentInformation);
        return $build->xml();
    }

}
