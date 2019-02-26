<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class Account extends Operation
{
    
    /**
     * @var string accounts operation endpoint
     */
    const ENDPOINT = 'accounts';

    /**
     * Constructor
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }
    

    /**
     * Listing accounts
     * You can see the list of accounts of a login. The accounts
     * are sorted in ascending order of their ID, so the newest
     * accounts will come last. You can read more about next_id
     * field, in the pagination section of the reference.
     *
     * from_id (string,optional) -the id from which the next page of accounts starts
     * login_id (string,optional) the ID of the login containing the accounts
     * customer_id (string,optional) -the ID of the customer containing the accounts.
     * Note: Will be ignored if login_id is present.
     *
     * @param  string $loginId
     * @return array
     * @throws \Exception
     */
    public function list(string $loginId): array
    {
        
        $endpoint = $this->url(self::ENDPOINT, ['login_id' => $loginId]);
        
        // Make request
        $raw = $this->connection->get($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
}
