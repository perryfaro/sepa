<?php

/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa\Builder;

use DOMDocument;
use DOMElement;

/**
 * Class Base
 *
 * @package silentgecko\Sepa\Builder
 */
class Base
{
    protected DOMDocument $dom;

    /**
     * @var DOMElement|false
     */
    protected $root;

    private string $painFormat = 'pain.001.001.03';

    public function __construct(string $painFormat = 'pain.001.001.03')
    {
        if (in_array($painFormat, ['pain.001.001.03', 'pain.001.003.03'])) {
            $this->painFormat = $painFormat;
        } else {
            throw new SepaSctException('Invalid painformat provided.');
        }

        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = true;
        $this->root = $this->dom->createElement('Document');
        $this->root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
        $this->root->setAttribute('xmlns', sprintf("urn:iso:std:iso:20022:tech:xsd:%s", $painFormat));
        $this->dom->appendChild($this->root);
    }

    public function getPainFormat(): string
    {
        return $this->painFormat;
    }

    protected function financialInstitution(string $bic = ''): DOMElement
    {
        if ($bic === '') {
            $bic = 'NOTPROVIDED';
        }
        $finInstitution = $this->createElement('FinInstnId');
        $finInstitution->appendChild($this->createElement('BIC', $bic));

        return $finInstitution;
    }

    protected function createElement(string $name, string $value = null): DOMElement
    {
        $elm = $this->dom->createElement($name);

        if ($value) {
            $elm->appendChild($this->dom->createTextNode($value));

            return $elm;
        }

        return $elm;
    }

    protected function IBAN(string $iban): DOMElement
    {
        $id = $this->createElement('Id');
        $id->appendChild($this->createElement('IBAN', $iban));
        return $id;
    }

    protected function remittence(string $remittenceInformation): DOMElement
    {
        $remittanceInformation = $this->createElement('RmtInf');
        $remittanceInformation->appendChild($this->createElement('Ustrd', $remittenceInformation));
        return $remittanceInformation;
    }
}
