<?php

namespace SaltEdge\Operation;

use SaltEdge\Request\SaltEdge;

class SaltEdgeUser extends Operation {
    
     /**
     * @var string token operation endpoint for create
     */
    const ENDPOINT_CREATE = 'customers';
    
     /**
     * @var array $response Response content after successful request
     */
    private $response;
    
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }
    
}