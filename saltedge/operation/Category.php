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
     const ENDPOINT_LEARN = "categories/learn";

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
    
     /**
     * Learn categories
     * You can change the category of some transactions, thus improving the categorization accuracy..
     *
     * @return array
     * @throws \Exception
     */
    public function change(string $transaction_id, string $category_code, bool $immediate = null ) 
    {
      
        $body = [ 'data' => [['transaction_id' => $transaction_id,'category_code'=>$category_code,'immediate' => $immediate]]];
        $raw = $this->connection->post($this->url(self::ENDPOINT_LEARN), $body);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();
        return $this->response;
    }
}
