<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

/**
 * Provider Class
 * This class helps to retrieve all available providers
 * or only one provider with given provider code.
 * @package SaltEdge\Operation
 */
class Provider extends Operation
{
    /**
     * @var  string provider operation endpoint
     */
    const ENDPOINT_PROVIDER = 'providers';

    /**
     * Constructor
     * @param SaltEdge $connection Connection information
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }

    /**
     * Retrieve provider information with given code
     * @param string $providerCode
     * @return array
     * @throws \Exception
     */
    public function get(string $providerCode) : array
    {
        $endpoint = $this->url(self::ENDPOINT_PROVIDER."/{$providerCode}");
        $raw = $this->connection->get($endpoint);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }

    /**
     * Retrieve all provider lists
     * @return array
     * @throws \Exception
     */
    public function all() : array
    {
        $raw = $this->connection->get($this->url(self::ENDPOINT_PROVIDER));
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this->response;
    }
}
