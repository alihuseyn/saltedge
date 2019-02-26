<?php

namespace SaltEdge\Operation;

/**
 * Provider Class
 * This class helps to retrieve all available providers
 * or only one provider with given provider code.
 * @package SaltEdge\Operation
 */
class Provider extends Operation
{
    /**
     * @var  string token operation endpoint for refresh
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
     * @return Provider
     * @throws \Exception
     */
    public function get(string $providerCode) : Provider
    {
        $raw = $this->connection->get(self::ENDPOINT_PROVIDER.concat("/{$providerCode}"));
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }

    /**
     * Retrieve all provider lists
     * @return Provider
     * @throws \Exception
     */
    public function all() : Provider
    {
        $raw = $this->connection->get(self::ENDPOINT_PROVIDER);
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }
}