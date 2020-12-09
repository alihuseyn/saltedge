<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class Connection extends Operation
{
    /**
     * @var string logins operation endpoint
     */
    const ENDPOINT = 'connections';

    /**
     * Constructor
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }

    /**
     * Listing Connections
     * Returns all the connections accessible to your application. The Connections are sorted in
     * ascending order of their ID, so the newest Connections will come last. We recommend you
     * fetch the whole list of logins to check whether any of the properties have changed.
     * You can read more about next_id field, in the pagination section of the reference.
     *
     * @see https://docs.saltedge.com/account_information/v5/#connections-list
     * @param  string $id - customer id
     * @return array
     * @throws \Exception
     * @todo  alihuseyng pagination
     */
    public function all(string $id) : array
    {
        $endpoint = $this->url(self::ENDPOINT, ['customer_id' => $id]);
        $raw = $this->connection->get($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }

    /**
     * Retrieve Connection
     * Returns a single Connection object.
     *
     * @see https://docs.saltedge.com/account_information/v5/#connections-show
     * @param  string $id - customer id
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
     * Remove Connection
     * Removes a Connection from our system.
     * All the associated accounts and transactions to that login will be destroyed as well.
     *
     * -id (string, required) - the id of login
     *
     * @see https://docs.saltedge.com/account_information/v5/#connections-remove
     * @param  $id
     * @return array
     * @throws \Exception
     */
    public function remove(string $id) : array
    {
        $raw = $this->connection->delete($this->url(self::ENDPOINT."/{$id}"));
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
}
