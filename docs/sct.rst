.. index::
   single: SEPA Credit Transfer (SCT)

Creating a SEPA Credit Transfer file
==================

Phinx relies on migrations in order to transform your database. Each migration
is represented by a PHP class in a unique file. It is preferred that you write
your migrations using the Phinx PHP API, but raw SQL is also supported.

Starting a new Sepa Credit Transfer
------------------------

Let's start by creating a new SEPA Credit Transfer object:

.. code-block:: php

        <?php

        $creditTransfer = new \Sepa\CreditTransfer(); 


Creating the header
------------------------

After that we will create a header. This contains the following data:

-  Control sum, this the amount of all your payments
-  The name that belongs to the IBAN
-  Message Identification, this should be always unique
-  The numbers of transactions


Example of header:

.. code-block:: php

        <?php

        //group header
        $groupHeader = new \Sepa\CreditTransfer\GroupHeader();
        $groupHeader->setControlSum(150.00)
           ->setInitiatingPartyName('Company name')
           ->setMessageIdentification('lkgjekrthrewkjtherwkjtherwkjtrhewr')
           ->setNumberOfTransactions(2);

         //add header to the credit transfer  
        $creditTransfer->setGroupHeader($groupHeader);

Payment information
------------------------

The payment information will contains at the end all payments and the information about the payer.

The payment information contains the debtor information:

-  IBAN debtor
-  The name that belong to the IBAN
-  Payment Information Identification, this should be always unique
-  The date the payment should be execute.

.. note::

    The are dates when there will be no transactions, you have to check this your self. See your bank for these days.

Example of the payment information:

.. code-block:: php

        <?php

        //create payment information
        $paymentInformation = new \Sepa\CreditTransfer\PaymentInformation;

        $paymentInformation
           ->setDebtorIBAN('NL91ABNA0417164300')
           ->setDebtorName('Name')
           ->setPaymentInformationIdentification('1281543153223-3463265456')
           ->setRequestedExecutionDate('2015-01-01');       


Add Payments
------------------------

Add the payments to the payment information that we want the payout. You can add multiple payments to the payment information.

The payment starts with the debtor information:

-  IBAN creditor
-  The name that belong to the IBAN
-  End to end id, this should be unique
-  Description that will be send with the transaction

Example of the payment:

.. code-block:: php

        <?php

        //payment
        $payment = new \Sepa\CreditTransfer\Payment;
        $payment->setAmount(50.00)
           ->setCreditorIBAN('NL91ABNA0417164300')
           ->setCreditorName('My Name 2')
           ->setEndToEndId('askfjhwqkjthewqjktewrter')
           ->setRemittanceInformation('Transaction information 1');

        //add the payment to the payment information
        $paymentInformation->addPayments($payment);

Create the SEPA Credit Transfer
------------------------

After we have setup a header, payment information and the payment we can create the Sepa Credit Transfer.

You can validate the file based on the XSD by using the validate method.

Example creating the file

.. code-block:: php

        <?php

        $creditTransfer->setPaymentInformation($paymentInformation);
        $xml = $creditTransfer->xml();

        $xml = $creditTransfer->xml();
        if ($creditTransfer->validate($xml) === true) {
            header('Content-type: "text/xml"; charset="utf8"');
            header('Content-Disposition: attachment; filename="sepa_credit_transfer.xml"');
            echo $xml;
        } else {
            new Throw Exception('The generate file does not match the XSD specs');
        }
        



