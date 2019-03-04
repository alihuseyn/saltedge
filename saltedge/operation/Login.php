<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class Login extends Operation
{
    /**
     * @var string logins operation endpoint
     */
    const ENDPOINT = 'logins';

    /**
     * Constructor
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }

    /**
     * Listing logins
     * Returns all the logins accessible to your application. The logins are sorted in
     * ascending order of their ID, so the newest logins will come last. We recommend you
     * fetch the whole list of logins to check whether any of the properties have changed.
     * You can read more about next_id field, in the pagination section of the reference.
     *
     * @see https://docs.saltedge.com/reference/#logins-list
     * @param  string $id
     * @return array
     * @throws \Exception
     */
    public function get(string $id) : array
    {
        $endpoint = $this->url(self::ENDPOINT, ['customer_id' => $id]);
        $raw = $this->connection->get($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }

    /**
     * Remove login
     * Removes a login from our system. 
     * All the associated accounts and transactions to that login will be destroyed as well.
     *
     * -id (string, required) - the id of login
     *
     * @see https://docs.saltedge.com/account_information/v4/#logins-remove
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
