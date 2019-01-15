<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

/**
 * Class Operation
 * The abstract class covers all the common functionality
 * exists between helper operations like connection and others.
 * @package SaltEdge\operation
 */
abstract class Operation
{
    /**
     * @param string URL api base url
     */
    const URL = 'https://www.saltedge.com/api/v4/';

    /**
     * @var SaltEdge $connection Connection information and API request functionality
     */
    protected $connection;

    /**
     * Operation constructor.
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Generate url for required endpoint with base url
     * @param $endpoint
     * @return string
     */
    public function url($endpoint)
    {
        return trim(self::URL . ltrim( $endpoint, '/'));
    }

}