<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

/**
 * @package SaltEdge\Operation
 */
class Category extends Operation
{

    /**
     * @var string categories endpoint
     */
    const ENDPOINT = "categories";

    /**
     * Transaction constructor.
     * @param SaltEdge $connection
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }


    /**
     * Listing categories
     * You can get the list of all the categories that we support.
     *
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
}
