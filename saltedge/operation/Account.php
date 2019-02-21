<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class Account extends Operation {
    
     /**
     * @var string token operation endpoint for create
     */
    const ENDPOINT = 'accounts';

    
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }
    

    /*
    Listing accounts
    You can see the list of accounts of a login. The accounts are sorted in ascending order of their ID, so the newest accounts will come last. You can read more about next_id field, in the pagination section of the reference.
    
    from_id (string,optional) -the id from which the next page of accounts starts
    login_id (string,optional) the ID of the login containing the accounts
    customer_id (string,optional) -the ID of the customer containing the accounts. Note: Will be ignored if login_id is present.
    
    */
    
    public function listAccounts($login_id)
    {
      
        // Make request
        $raw = $this->connection->get($this->url(self::ENDPOINT."?login_id=".$login_id));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
    
}