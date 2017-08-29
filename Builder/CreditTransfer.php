<?php

/**
 * CreditTransfer
 *
 * @author Perry Faro 2015
 * @license MIT
 */

namespace Sepa\Builder;

use Sepa\Builder\Base;
use Sepa\CreditTransfer\GroupHeader;
use Sepa\CreditTransfer\PaymentInformation;

class CreditTransfer extends Base {

    public function __construct($painFormat = 'pain.001.001.03') {
        parent::__construct($painFormat);
        $this->transfer = $this->createElement('CstmrCdtTrfInitn');
        $this->root->appendChild($this->transfer);
    }

    /**
     * 
     * @param GroupHeader $groupHeader
     */
    public function appendGroupHeader(GroupHeader $groupHeader) {
        $groupHeaderElement = $this->createElement('GrpHdr');

        $messageIdentification = $this->createElement('MsgId', $groupHeader->getMessageIdentification());
        $groupHeaderElement->appendChild($messageIdentification);

        $creationDateTime = $this->createElement('CreDtTm', $groupHeader->getCreationDateTime()->format('Y-m-d\TH:i:s\Z'));
        $groupHeaderElement->appendChild($creationDateTime);

        $numberOfTransactions = $this->createElement('NbOfTxs', $groupHeader->getNumberOfTransactions());
        $groupHeaderElement->appendChild($numberOfTransactions);

        $controlSum = $this->createElement('CtrlSum', $groupHeader->getControlSum());
        $groupHeaderElement->appendChild($controlSum);

        $initiatingParty = $this->createElement('InitgPty');
        $initiatingPartyName = $this->createElement('Nm', $groupHeader->getInitiatingPartyName());
		$initiatingParty->appendChild($initiatingPartyName);
		
		if($groupHeader->getNifSuffix()!=""){
			$id_ = $this->createElement('Id');
			$orgId = $this->createElement('OrgId');
			$othr = $this->createElement('Othr');
			$id_2 = $this->createElement('Id',$groupHeader->getNifSuffix());
		
			$othr->appendChild($id_2);
			$orgId->appendChild($othr);
			$id_->appendChild($orgId);
			$initiatingParty->appendChild($id_);
		}
        $groupHeaderElement->appendChild($initiatingParty);

        $this->transfer->appendChild($groupHeaderElement);
    }

    public function appendPaymentInformation(PaymentInformation $paymentInformation,GroupHeader $groupHeader) {
        $this->payment = $this->createElement('PmtInf');

        $paymentInformationIdentification = $this->createElement('PmtInfId', $paymentInformation->getPaymentInformationIdentification());
        $this->payment->appendChild($paymentInformationIdentification);

        $paymentMethod = $this->createElement('PmtMtd', $paymentInformation->getPaymentMethod());
        $this->payment->appendChild($paymentMethod);

        if ($paymentInformation->getNumberOfTransactions() !== false) {
            $numberOfTransactions = $this->createElement('NbOfTxs', $paymentInformation->getNumberOfTransactions());
            $this->payment->appendChild($numberOfTransactions);
        }
        if ($paymentInformation->getControlSum() !== false) {
            $controlSum = $this->createElement('CtrlSum', $paymentInformation->getControlSum());
            $this->payment->appendChild($controlSum);
        }

        $requestedExecutionDate = $this->createElement('ReqdExctnDt', $paymentInformation->getRequestedExecutionDate());
        $this->payment->appendChild($requestedExecutionDate);

        $debtor = $this->createElement('Dbtr');
        $debtor->appendChild($this->createElement('Nm', $paymentInformation->getDebtorName()));
        $this->payment->appendChild($debtor);

		if($groupHeader->getNifSuffix()!=""){
			// some banks also needs company id inside PmtInf (Payment Information)
			
			$id_ = $this->createElement('Id');
			$orgId = $this->createElement('OrgId');
			$othr = $this->createElement('Othr');
			$id_2 = $this->createElement('Id',$groupHeader->getNifSuffix());
		
			$othr->appendChild($id_2);
			$orgId->appendChild($othr);
			$id_->appendChild($orgId);
			$debtor->appendChild($id_);
		}
		
        $debtorAgentAccount = $this->createElement('DbtrAcct');
        $debtorAgentAccount->appendChild($this->IBAN($paymentInformation->getDebtorIBAN()));
        $this->payment->appendChild($debtorAgentAccount);
        
        $debtorAgent = $this->createElement('DbtrAgt');
        $debtorAgent->appendChild($this->financialInstitution($paymentInformation->getDebtorBIC()));
        $this->payment->appendChild($debtorAgent);

        $this->appendPayments($paymentInformation->getPayments());

        $this->transfer->appendChild($this->payment);
    }

    protected function appendPayments($payments) {
        foreach ($payments as $payment) {
            $creditTransferTransactionInformation = $this->createElement('CdtTrfTxInf');

            $paymentIdentification = $this->createElement('PmtId');
            $paymentIdentification->appendChild($this->createElement('EndToEndId', $payment->getEndToEndId()));
            $creditTransferTransactionInformation->appendChild($paymentIdentification);
			
			if($payment->getCtgyPurp() != false || $payment->getIsSepa() ){
				$paymentTypeInformation = $this->createElement("PmtTpInf");

				if($payment->getIsSepa()){
					$serviceLevel = $this->createElement('SvcLvl');
					$serviceLevelCode = $this->createElement('Cd', "SEPA");
					$serviceLevel->appendChild($serviceLevelCode);
					$paymentTypeInformation->appendChild($serviceLevel);
				}	

				if($payment->getCtgyPurp() != false){
					$category = $this->createElement('CtgyPurp');
					$categoryValue = $this->createElement('Cd', $payment->getCtgyPurp());
					$category->appendChild($categoryValue);
					$paymentTypeInformation->appendChild($category);
				}	

				$creditTransferTransactionInformation->appendChild($paymentTypeInformation);
			}

            $amount = $this->createElement('Amt');
            $instructedAmount = $this->createElement('InstdAmt', $payment->getAmount());
            $instructedAmount->setAttribute('Ccy', $payment->getCurrency());
            $amount->appendChild($instructedAmount);
            $creditTransferTransactionInformation->appendChild($amount);

            $creditorAgent = $this->createElement('CdtrAgt');
            $financialInstitution = $this->createElement('FinInstnId');
            $financialInstitution->appendChild($this->createElement('BIC', $payment->getCreditorBIC()));
            $creditorAgent->appendChild($financialInstitution);
            $creditTransferTransactionInformation->appendChild($creditorAgent);

            $creditor = $this->createElement('Cdtr');
            $creditor->appendChild($this->createElement('Nm', $payment->getCreditorName()));

			if($payment->getCreditorCountry() != '' || 
			   $payment->getCreditorAddress() != '' ||
			   $payment->getCreditorAddress2()!= '' ){
				$postalAddress = $creditor->appendChild($this->createElement('PstlAdr'));
				if($payment->getCreditorCountry() != ''){
		            $postalAddress->appendChild($this->createElement('Ctry', $payment->getCreditorCountry()));
				}
				if($payment->getCreditorAddress() != ''){
		            $postalAddress->appendChild($this->createElement('AdrLine', $payment->getCreditorAddress()));
				}
				if($payment->getCreditorAddress2() != ''){
		            $postalAddress->appendChild($this->createElement('AdrLine', $payment->getCreditorAddress2()));
				}
			}

            $creditTransferTransactionInformation->appendChild($creditor);

            $creditorAccount = $this->createElement('CdtrAcct');
            $id = $this->createElement('Id');
            $id->appendChild($this->createElement('IBAN', $payment->getCreditorIBAN()));
            $creditorAccount->appendChild($id);
            $creditTransferTransactionInformation->appendChild($creditorAccount);

            $remittanceInformation = $this->remittence($payment->getRemittanceInformation());
            $creditTransferTransactionInformation->appendChild($remittanceInformation);
            $this->payment->appendChild($creditTransferTransactionInformation);
        }
    }

    /**
     * Return xml
     * 
     * @return string
     */
    public function xml() {
        return (string) $this->dom->saveXML();
    }

}
