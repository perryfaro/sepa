# SEPA Credit Transfer

[![Build Status](https://travis-ci.org/silentgecko/sepa.svg?branch=master)](https://travis-ci.org/silentgecko/sepa)

### Installation using Composer

```
composer require silentgecko/sepa
```

### Example

```php
$creditTransfer = new \silentgecko\Sepa\CreditTransfer();
//group header
$groupHeader = new \silentgecko\Sepa\CreditTransfer\GroupHeader();
$groupHeader->setControlSum(150.00)
        ->setInitiatingPartyName('Company name')
        ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
        ->setNumberOfTransactions(2);
$creditTransfer->setGroupHeader($groupHeader);
//payment information
$paymentInformation = new \silentgecko\Sepa\CreditTransfer\PaymentInformation;

$paymentInformation
        ->setDebtorIBAN('NL91ABNA0417164300')
        ->setDebtorName('Name')
        ->setPaymentInformationIdentification('1281543153223-3463265456')
        ->setRequestedExecutionDate('2015-01-01');

//payment
$payment = new \silentgecko\Sepa\CreditTransfer\Payment;
$payment->setAmount(100.00)
        ->setCreditorBIC('ABNANL2A')
        ->setCreditorIBAN('NL91ABNA0417164300')
        ->setCreditorName('My Name')
        ->setEndToEndId('askfjhwqkjthewqjktewrter')
        ->setRemittanceInformation('Transaction testing');

$paymentInformation->addPayments($payment);
//payment
$payment = new \silentgecko\Sepa\CreditTransfer\Payment;
$payment->setAmount(50.00)
        ->setCreditorIBAN('NL91ABNA0417164300')
        ->setCreditorName('My Name 2')
        ->setEndToEndId('askfjhwqkjthewqjktewrter')
        ->setRemittanceInformation('Transaction testing 2');

$paymentInformation->addPayments($payment);

$creditTransfer->setPaymentInformation($paymentInformation);

// default is pain.001.001.03.xsd schema format, but you can also use the newer pain.001.003.03.xsd
$painformat = 'pain.001.001.03.xsd'; 
$xml = $creditTransfer->xml($painformat);
//validation
$creditTransfer->validate($xml, $painformat);
```
