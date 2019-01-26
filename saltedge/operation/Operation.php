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
     * @var array $response Response content after successful request
     */
    protected $response;


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
     * and given query parameters
     * @param $endpoint
     * @param $query
     * @return string
     */
    public function url($endpoint,array $query = [])
    {
        $url = trim(self::URL . ltrim( $endpoint, '/'));
        if (!empty($query)) {
            $_ = [];
            foreach ($query as $q => $v) {
                if (!empty($v)) {
                    array_push($_, "{$q}={$v}");
                }
            }
            $url .= "?".implode("&", $_);
        }

        return $url;
    }

    /**
     * @return array return response after successful request
     */
    public function response():array
    {
        return $this->response;
    }
}