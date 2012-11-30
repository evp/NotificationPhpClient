<?php

/**
 * Holds information about notification (data itself)
 */
class Evp_Notification_Entity_OperationNotification
{
    const TYPE_PAYMENT = 'MK';
    const TYPE_DEPOSITS = 'HO';
    const TYPE_CURRENCY_EXCHANGE = 'FX';
    const TYPE_OTHER_TRANSACTION = 'MM';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $account;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $fromAmount;

    /**
     * @var string
     */
    protected $fromCurrency;

    /**
     * @var string
     */
    protected $toAmount;

    /**
     * @var string
     */
    protected $toCurrency;

    /**
     * @var bool|null
     */
    protected $credit;

    /**
     * @var string
     */
    protected $beneficiaryName;

    /**
     * @var string
     */
    protected $beneficiaryAccount;

    /**
     * @var string
     */
    protected $beneficiaryCode;

    /**
     * @var string
     */
    protected $payerName;

    /**
     * @var string
     */
    protected $payerAccount;

    /**
     * @var string
     */
    protected $payerCode;

    /**
     * @var string
     */
    protected $details;

    /**
     * @var string
     */
    protected $referenceNumber;

    /**
     * @var string
     */
    protected $referenceToBeneficiary;

    /**
     * @var string
     */
    protected $referenceToPayer;

    /**
     * @var int
     */
    protected $transferId;

    /**
     * Gets account
     *
     * @param string $account
     *
     * @return self
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Gets amount
     *
     * @param string $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Gets beneficiaryAccount
     *
     * @param string $beneficiaryAccount
     *
     * @return self
     */
    public function setBeneficiaryAccount($beneficiaryAccount)
    {
        $this->beneficiaryAccount = $beneficiaryAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getBeneficiaryAccount()
    {
        return $this->beneficiaryAccount;
    }

    /**
     * Gets beneficiaryCode
     *
     * @param string $beneficiaryCode
     *
     * @return self
     */
    public function setBeneficiaryCode($beneficiaryCode)
    {
        $this->beneficiaryCode = $beneficiaryCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBeneficiaryCode()
    {
        return $this->beneficiaryCode;
    }

    /**
     * Gets beneficiaryName
     *
     * @param string $beneficiaryName
     *
     * @return self
     */
    public function setBeneficiaryName($beneficiaryName)
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    /**
     * @return string
     */
    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    /**
     * Gets credit
     *
     * @param bool|null $credit
     *
     * @return self
     */
    public function setCredit($credit)
    {
        $this->credit = $credit === null ? null : (bool) $credit;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Gets currency
     *
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Gets details
     *
     * @param string $details
     *
     * @return self
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Gets fromAmount
     *
     * @param string $fromAmount
     *
     * @return self
     */
    public function setFromAmount($fromAmount)
    {
        $this->fromAmount = $fromAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromAmount()
    {
        return $this->fromAmount;
    }

    /**
     * Gets fromCurrency
     *
     * @param string $fromCurrency
     *
     * @return self
     */
    public function setFromCurrency($fromCurrency)
    {
        $this->fromCurrency = $fromCurrency;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    /**
     * Gets payerAccount
     *
     * @param string $payerAccount
     *
     * @return self
     */
    public function setPayerAccount($payerAccount)
    {
        $this->payerAccount = $payerAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerAccount()
    {
        return $this->payerAccount;
    }

    /**
     * Gets payerCode
     *
     * @param string $payerCode
     *
     * @return self
     */
    public function setPayerCode($payerCode)
    {
        $this->payerCode = $payerCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerCode()
    {
        return $this->payerCode;
    }

    /**
     * Gets payerName
     *
     * @param string $payerName
     *
     * @return self
     */
    public function setPayerName($payerName)
    {
        $this->payerName = $payerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerName()
    {
        return $this->payerName;
    }

    /**
     * Gets referenceNumber
     *
     * @param string $referenceNumber
     *
     * @return self
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Gets referenceToBeneficiary
     *
     * @param string $referenceToBeneficiary
     *
     * @return self
     */
    public function setReferenceToBeneficiary($referenceToBeneficiary)
    {
        $this->referenceToBeneficiary = $referenceToBeneficiary;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceToBeneficiary()
    {
        return $this->referenceToBeneficiary;
    }

    /**
     * Gets referenceToPayer
     *
     * @param string $referenceToPayer
     *
     * @return self
     */
    public function setReferenceToPayer($referenceToPayer)
    {
        $this->referenceToPayer = $referenceToPayer;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceToPayer()
    {
        return $this->referenceToPayer;
    }

    /**
     * Gets toAmount
     *
     * @param string $toAmount
     *
     * @return self
     */
    public function setToAmount($toAmount)
    {
        $this->toAmount = $toAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getToAmount()
    {
        return $this->toAmount;
    }

    /**
     * Gets toCurrency
     *
     * @param string $toCurrency
     *
     * @return self
     */
    public function setToCurrency($toCurrency)
    {
        $this->toCurrency = $toCurrency;

        return $this;
    }

    /**
     * @return string
     */
    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    /**
     * Gets transferId
     *
     * @param int|null $transferId
     *
     * @return self
     */
    public function setTransferId($transferId)
    {
        $this->transferId = $transferId === null ? null : (int) $transferId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTransferId()
    {
        return $this->transferId;
    }

    /**
     * Gets type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isTypeCurrencyExchange()
    {
        return $this->type === self::TYPE_CURRENCY_EXCHANGE;
    }

    /**
     * @return bool
     */
    public function isTypeDeposits()
    {
        return $this->type === self::TYPE_DEPOSITS;
    }

    /**
     * @return bool
     */
    public function isTypeOtherTransaction()
    {
        return $this->type === self::TYPE_OTHER_TRANSACTION;
    }

    /**
     * @return bool
     */
    public function isTypePayment()
    {
        return $this->type === self::TYPE_PAYMENT;
    }

    /**
     * Creates instance from array of parameters
     *
     * @param array $params
     *
     * @return Evp_Notification_Entity_OperationNotification
     */
    public static function fromParams(array $params)
    {
        $notification = new self();
        $notification
            ->setType(isset($params['type']) ? $params['type'] : null)
            ->setCredit(isset($params['credit']) ? $params['credit'] : null)
            ->setAccount(isset($params['account']) ? $params['account'] : null)
            ->setAmount(isset($params['amount']) ? $params['amount'] : null)
            ->setCurrency(isset($params['currency']) ? $params['currency'] : null)
            ->setFromAmount(isset($params['from_amount']) ? $params['from_amount'] : null)
            ->setFromCurrency(isset($params['from_currency']) ? $params['from_currency'] : null)
            ->setToAmount(isset($params['to_amount']) ? $params['to_amount'] : null)
            ->setToCurrency(isset($params['to_currency']) ? $params['to_currency'] : null)
            ->setBeneficiaryName(isset($params['beneficiary_name']) ? $params['beneficiary_name'] : null)
            ->setBeneficiaryCode(isset($params['beneficiary_code']) ? $params['beneficiary_code'] : null)
            ->setBeneficiaryAccount(isset($params['beneficiary_account']) ? $params['beneficiary_account'] : null)
            ->setPayerName(isset($params['payer_name']) ? $params['payer_name'] : null)
            ->setPayerCode(isset($params['payer_code']) ? $params['payer_code'] : null)
            ->setPayerAccount(isset($params['payer_account']) ? $params['payer_account'] : null)
            ->setDetails(isset($params['details']) ? $params['details'] : null)
            ->setTransferId(isset($params['transfer_id']) ? $params['transfer_id'] : null)
            ->setReferenceNumber(isset($params['reference_number']) ? $params['reference_number'] : null)
            ->setReferenceToBeneficiary(isset($params['reference_to_beneficiary']) ? $params['reference_to_beneficiary'] : null)
            ->setReferenceToPayer(isset($params['reference_to_payer']) ? $params['reference_to_payer'] : null)
        ;
        return $notification;
    }
}
