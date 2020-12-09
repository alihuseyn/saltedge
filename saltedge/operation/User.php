<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class User extends Operation
{
 
    /**
     * @var string customer operation endpoint
     */
    const ENDPOINT = 'customers';
    
    /**
     * Constructor
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }
    
    /**
     * Create customer
     * Creates a customer, returning response.
     *
     * -identifier (string, required) - a unique identifier of the new customer
     *
     * @see https://docs.saltedge.com/reference/#customers
     * @param  string $identifier
     * @return array
     * @throws \Exception
     */
    public function create(string $identifier): array
    {
        // Request Body
        $body = [ 'data' => ['identifier' => $identifier]];
        
        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT), $body);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
    

    
    /**
     * Returns the customer object.
     * -id (string, required) - the id of customer
     *
     * @see https://docs.saltedge.com/reference/#customers
     * @param  string $id
     * @return array
     * @throws \Exception
     */
    public function get(string $id) : array
    {
        $raw = $this->connection->get($this->url(self::ENDPOINT."/{$id}"));
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
     
    /**
     * List all of your app’s customers.
     * This route is available only for web applications, not mobile ones.
     * @todo alihuseyng list return pagination 
     * @see https://docs.saltedge.com/reference/#customers
     * @return array
     * @throws \Exception
     */
    public function list() : array
    {
        $raw = $this->connection->get($this->url(self::ENDPOINT));
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
    
    /**
     * Remove customer
     * Deletes a customer, returning the customer object.
     * This route is available only for web applications.
     *
     * -id (string, required) - the id of customer
     *
     * @see https://docs.saltedge.com/reference/#customers
     * @param  $id
     * @return array
     * @throws \Exception
     */
    public function remove(string $id): array
    {
        $raw = $this->connection->delete($this->url(self::ENDPOINT."/{$id}"));
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
    
    /**
     * Lock customer
     * Locks a customer and its data, returning the customer object.
     * All customer related data including logins, accounts, transactions, attempts will not
     * be available for reading, updating or deleting even by Salt Edge.
     * This route is available only for web applications.
     *
     * -id (string, required) - the id of customer
     *
     * @see https://docs.saltedge.com/reference/#customers
     * @param  string $id
     * @return array
     * @throws \Exception
     */
    public function lock(string $id) : array
    {
        $endpoint = $this->url(self::ENDPOINT."/{$id}/lock");
        $raw = $this->connection->put($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
    
    /**
     * Unlock customer
     * Unlocks a customer and its data, returning the customer object.
     * This route is available only for web applications.
     *
     * -id (string, required) - the id of customer
     *
     * @see https://docs.saltedge.com/reference/#customers
     * @param  string $id
     * @return array
     */
    public function unlock(string $id) : array
    {
        $endpoint = $this->url(self::ENDPOINT."/{$id}/unlock");
        $raw = $this->connection->put($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
}
