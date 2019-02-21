<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

/**
 * Class Transaction
 * We use this class to fetch transactions related with given
 * account information.
 * A transaction represents a movement of funds. Any transaction can represent a
 * monetary transfer, withdrawal, income or expense interchange.
 * @package SaltEdge\Operation
 */
class Category extends Operation
{

    /**
     * @var string transactions endpoint
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


    /* 
    
    Listing categories
    You can get the list of all the categories that we support.
    
    */
    
    public function list()
    {
       
        $raw = $this->connection->get($this->url(self::ENDPOINT));
        $this->response = json_decode($raw, true);
        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this->response;
    }
}
