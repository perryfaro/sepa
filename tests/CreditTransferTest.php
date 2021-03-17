<?php
/**
 * @author Perry Faro 2015
 * @author René Welbers 2021 <info@wereco.de>
 * @license MIT
 */

namespace silentgecko\Sepa;

use PHPUnit\Framework\TestCase;
use silentgecko\Sepa\Builder\SepaSctException;
use silentgecko\Sepa\CreditTransfer\GroupHeader;
use silentgecko\Sepa\CreditTransfer\Payment;
use silentgecko\Sepa\CreditTransfer\PaymentInformation;

date_default_timezone_set('Europe/Amsterdam');

/**
 * Class CreditTransferTest
 *
 * @package silentgecko\Sepa
 */
class CreditTransferTest extends TestCase
{

    public function dataProviderPainFormats() :array
    {
        return [
            ['painFormat' => 'pain.001.001.03',], ['painFormat' => 'pain.001.003.03',]
        ];
    }

    /**
     * @dataProvider dataProviderPainFormats
     */
    public function testCreateTransfer(string $painFormat) :void
    {
        $creditTransfer = new CreditTransfer();
        //group header
        $groupHeader = new GroupHeader();
        $groupHeader->setControlSum(150.00)
            ->setInitiatingPartyName('Company name')
            ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
            ->setNumberOfTransactions(2)
            ->setInitiatingPartyId('test');
        $creditTransfer->setGroupHeader($groupHeader);
        //payment information
        $paymentInformation = new PaymentInformation();

        $paymentInformation
            ->setDebtorIBAN('NL91ABNA0417164300')
            ->setDebtorName('Name')
            ->setDebtorBIC('')
            ->setPaymentInformationIdentification('1281543153223-3463265456')
            ->setRequestedExecutionDate('2015-01-01')
            ->setControlSum(150)
            ->setNumberOfTransactions(2);

        //payment
        $payment = new Payment();
        $payment->setAmount(100.00)
            ->setCreditorBIC('ABNANL2A')
            ->setCreditorBIC('NOTPROVIDED')
            ->setCreditorIBAN('NL91ABNA0417164300')
            ->setCreditorName('My Name')
            ->setEndToEndId('askfjhwqkjthewqjktewrter')
            ->setRemittanceInformation('Transaction testing')
            ->setCurrency('EUR');

        $paymentInformation->addPayments($payment);
        //payment
        $payment = new Payment();
        $payment->setAmount(50.00)
            ->setCreditorIBAN('NL91ABNA0417164300')
            ->setCreditorName('My Name 2')
            ->setCreditorBIC('')
            ->setEndToEndId('askfjhwqkjthewqjktewrter')
            ->setRemittanceInformation('Transaction testing 2')
            ->setCurrency('CHF');

        $paymentInformation->addPayments($payment);

        $creditTransfer->setPaymentInformation($paymentInformation);
        $xml = $creditTransfer->xml($painFormat);
        $this->assertTrue($creditTransfer->validate($xml, $painFormat));
    }

    public function testCreateWrongPainFormat()
    {
        $creditTransfer = new CreditTransfer();
        $groupHeader = new GroupHeader();
        $groupHeader->setControlSum(150.00)
            ->setInitiatingPartyName('Company name')
            ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
            ->setNumberOfTransactions(2)
            ->setInitiatingPartyId('test');
        $creditTransfer->setGroupHeader($groupHeader);


        $paymentInformation = new PaymentInformation();
        $paymentInformation
            ->setDebtorIBAN('NL91ABNA0417164300')
            ->setDebtorName('Name')
            ->setDebtorBIC('')
            ->setPaymentInformationIdentification('1281543153223-3463265456')
            ->setRequestedExecutionDate('2015-01-01')
            ->setControlSum(150)
            ->setNumberOfTransactions(2);
        $creditTransfer->setPaymentInformation($paymentInformation);

        $this->expectException(SepaSctException::class);
        $this->expectExceptionMessage('Invalid painformat provided.');
        $xml = $creditTransfer->xml('wrong');
    }

    public function testEmptyGroupHeaderWillThrowException()
    {
        $creditTransfer = new CreditTransfer();
        $paymentInformation = new PaymentInformation();
        $paymentInformation
            ->setDebtorIBAN('NL91ABNA0417164300')
            ->setDebtorName('Name')
            ->setDebtorBIC('')
            ->setPaymentInformationIdentification('1281543153223-3463265456')
            ->setRequestedExecutionDate('2015-01-01')
            ->setControlSum(150)
            ->setNumberOfTransactions(2);
        $creditTransfer->setPaymentInformation($paymentInformation);

        $this->expectException(SepaSctException::class);
        $this->expectExceptionMessage('GroupHeader cannot be empty.');
        $xml = $creditTransfer->xml('wrong');
    }

    public function testEmptyPaymentInformationWillThrowException()
    {
        $creditTransfer = new CreditTransfer();
        $groupHeader = new GroupHeader();
        $groupHeader->setControlSum(150.00)
            ->setInitiatingPartyName('Company name')
            ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
            ->setNumberOfTransactions(2)
            ->setInitiatingPartyId('test');
        $creditTransfer->setGroupHeader($groupHeader);

        $this->expectException(SepaSctException::class);
        $this->expectExceptionMessage('PaymentInformation cannot be empty.');
        $xml = $creditTransfer->xml('wrong');
    }

    public function testDoesNotValidate()
    {
        $creditTransfer = new CreditTransfer();
        $groupHeader = new GroupHeader();
        $groupHeader->setControlSum(150)
                    ->setInitiatingPartyName('Company name')
                    ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
                    ->setNumberOfTransactions(2)
                    ->setInitiatingPartyId('test');
        $creditTransfer->setGroupHeader($groupHeader);


        $paymentInformation = new PaymentInformation();
        $paymentInformation
            ->setDebtorIBAN('NL91ABNA0417164300')
            ->setDebtorName('Name')
            ->setDebtorBIC('')
            ->setPaymentInformationIdentification('1281543153223-3463265456')
            ->setRequestedExecutionDate('2015-01-01')
            ->setControlSum(150)
            ->setNumberOfTransactions(2);
        $creditTransfer->setPaymentInformation($paymentInformation);

        $this->expectError();
        $this->expectErrorMessage("DOMDocument::schemaValidate(): Element '{urn:iso:std:iso:20022:tech:xsd:pain.001.001.03}Document': No matching global declaration available for the validation root.");
        $xml = $creditTransfer->xml();
        $creditTransfer->validate($xml, 'pain.001.003.03');
    }
}
