<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;
use SaltEdge\Traits\HasPagination;

/**
 * Class Transaction
 * We use this class to fetch transactions related with given
 * account information.
 * A transaction represents a movement of funds. Any transaction can represent a
 * monetary transfer, withdrawal, income or expense interchange.
 * @package SaltEdge\Operation
 */
class Transaction extends Operation
{

    use HasPagination;

    /**
     * @var string transactions endpoint
     */
    const ENDPOINT_TRANSACTION = "transactions";

    /**
     * Transaction constructor.
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }


    /**
     * Retrieve all transactions.
     *
     * Parameters:
     * ----------------
     * account_id (string, optional) - the id of the account, required unless login_id parameter is sent
     * login_id (string, optional) - the id of the login, required unless account_id parameter is sent
     * from_id (string, optional) - the id from which the next page of transactions starts
     *
     * Attributes:
     * ----------------
     * id (string)
     * mode (string) - possible values are: normal, fee, transfer
     * status (string) - possible values are: posted, pending
     * made_on (date) - the date when the transaction was made
     * amount (decimal) - transaction’s amount
     * currency_code (string) - transaction’s currency code
     * description (text) - transaction’s description
     * category (string) - transaction’s category
     * duplicated (boolean) - whether the transaction is duplicated or not
     * extra (array) - extra data associated with the transaction
     * account_id (string) - the id of the account the transaction belongs to
     * created_at (datetime)
     * updated_at (datetime)
     * @param array $params
     * @return SaltEdge\Operation\Transaction
     * @throws \Exception
     */
    public function list(array $params)
    {

        if (empty($params) || (!isset($params['account_id']) && !isset($params['login_id']))) {
            throw new \Exception("Account ID or Login ID can't be empty or null.");
        }

        // Make Request
        // Generate required url with query parameters
        $url = isset($params['account_id'])
            ? $this->url(self::ENDPOINT_TRANSACTION, [
                'account_id' => $params['account_id'],
                'from_id' => $params['from_id'] ?? null
            ])
            : $this->url(self::ENDPOINT_TRANSACTION, [
                'login_id' => $params['login_id'],
                'from_id' => $params['from_id'] ?? null
            ]);

        $raw = $this->connection->get($url);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
    }

    /**
     * Mark a list of transactions as duplicated.
     * @param array $transactions - list of transaction id
     * @return itself
     */
    public function duplicate(array $transactions)
    {
        if (empty($transactions)) {
            throw new \Exception("The list of transactions can't be empty");
        }

        $url = $this->url(self::ENDPOINT_TRANSACTION . '/duplicate');

        $body = array_map(function ($transaction) {
            return ['transaction_id' => $transaction];
        }, $transactions);


        $raw = $this->connection->put($url, [ 'data' => $body ]);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
    }

    /**
     * Remove duplicated flag from a list of transactions.
     * @param array $transactions - list of transaction id
     * @return itself
     */
    public function unduplicate(array $transactions)
    {
        if (empty($transactions)) {
            throw new \Exception("The list of transactions can't be empty");
        }

        $url = $this->url(self::ENDPOINT_TRANSACTION . '/unduplicate');

        $body = array_map(function ($transaction) {
            return ['transaction_id' => $transaction];
        }, $transactions);


        $raw = $this->connection->put($url, [ 'data' => $body ]);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
    }
}
