<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class SaltEdgeUser extends Operation {
    
     /**
     * @var string token operation endpoint for create
     */
    const ENDPOINT = 'customers';
    const ENDPOINT_LOGINS = 'logins';
    
     /**
     * @var array $response Response content after successful request
     */
    protected $private;
    
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }
    

    /* Create customer
       Creates a customer, returning the customer object.
       
       -identifier (string, required) - a unique identifier of the new customer
        
        @see https://docs.saltedge.com/reference/#customers
        @param $identifier
        @throws \Exception
        @return SaltEdgeUser
    */
    
    public function create($identifier)
    {
        // Request Body
        $body = [ 'data' => ['identifier' => $identifier]];
        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT), $body);
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
     /* Show customer
        Returns the customer object.
       
       -id (string, required) - the id of customer
        
        @see https://docs.saltedge.com/reference/#customers
        @param $id
        @throws \Exception
        @return SaltEdgeUser
    */
    
    public function show($id)
    {
        
        // Make request
        $raw = $this->connection->get($this->url(self::ENDPOINT."/".$id));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
      /* 
        List customers
        List all of your app’s customers. This route is available only for web applications, not mobile ones.
        
        @see https://docs.saltedge.com/reference/#customers
        @throws \Exception
        @return SaltEdgeUser
    */
     
     public function list()
    {
       
        // Make request
        $raw = $this->connection->get($this->url(self::ENDPOINT));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
    
    /* 
        Remove customer
        Deletes a customer, returning the customer object. This route is available only for web applications.
         
        -id (string, required) - the id of customer
        
        @see https://docs.saltedge.com/reference/#customers
        @param $id
        @throws \Exception
        @return SaltEdgeUser
    */
    
    public function remove($id)
    {
        // Make request
        $raw = $this->connection->delete($this->url(self::ENDPOINT."/".$id));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
     /* 
        Lock customer
        Locks a customer and its data, returning the customer object.
        All customer related data including logins, accounts, transactions, attempts will not be available for reading, updating or deleting even by Salt Edge. This route is available only for web applications.  
        
        -id (string, required) - the id of customer
        
        @see https://docs.saltedge.com/reference/#customers
        @param $id
        @throws \Exception
        @return SaltEdgeUser
    */
     
     public function lock($id)
    {
         // Make request
        $raw = $this->connection->put($this->url(self::ENDPOINT."/".$id."/lock"));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
       /* 
        }
        Unlock customer
        Unlocks a customer and its data, returning the customer object. This route is available only for web applications.    
        
        -id (string, required) - the id of customer
        
        @see https://docs.saltedge.com/reference/#customers
        @param $id
        @throws \Exception
        @return SaltEdgeUser
    */
     
     public function unlock($id)
    {
         // Make request
        $raw = $this->connection->put($this->url(self::ENDPOINT."/".$id."/unlock"));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
    /*
    Listing logins
    Returns all the logins accessible to your application. The logins are sorted in ascending order of their ID, so the newest logins will come last. We recommend you fetch the whole list of logins to check whether any of the properties have changed. You can read more about next_id field, in the pagination section of the reference.
    
        -id (string, required) - the id of customer
        
        @see https://docs.saltedge.com/reference/#logins-list
        @param $id
        @throws \Exception
        @return SaltEdgeUser
    
    */
    
    public function listLogin($id)
    {
         // Make request
        $raw = $this->connection->get($this->url(self::ENDPOINT_LOGINS."?customer_id=".$id));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
    
}