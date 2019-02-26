<?php

namespace SaltEdge;

use SaltEdge\Operation\Account;
use SaltEdge\Operation\Provider;
use SaltEdge\Operation\Token;
use SaltEdge\Operation\Transaction;
use SaltEdge\Request\SaltEdge;
use SaltEdge\Operation\SaltEdgeUser;
use SaltEdge\Operation\Category;

/**
 * Class Spectre
 * This class covers all the functionality required to make communication
 * with SaltEdge. The required functionality instance create only implemented.
 * @package SaltEdge
 */
class Spectre
{

    /**
     * @var SaltEdge $connection Required API Connection functions and connection details
     */
    private $connection;

    /**
     * Spectre constructor.
     * @param $app_id
     * @param $app_secret
     * @param $privateKeyPath
     * @param $privateKeyPass
     */
    public function __construct($appId, $appSecret, $privateKeyPath, $privateKeyPass = null)
    {
        $this->connection = new SaltEdge($appId, $appSecret, $privateKeyPath, $privateKeyPass);
    }


    /**
     * Static Spectre Instance initialize
     * @param $appId
     * @param $appSecret
     * @param $privateKeyPath
     * @param $privateKeyPass
     * @return Spectre
     */
    public static function instance($appId, $appSecret, $privateKeyPath, $privateKeyPass)
    {
        return new Spectre($appId, $appSecret, $privateKeyPath, $privateKeyPass);
    }

    /**
     * Initialize token class and return it
     * @return Token
     */
    public function token() : Token
    {
        return new Token($this->connection);
    }

    /**

     * Initialize transaction class and return it
     * @return Transaction
     */
    public function transaction(): Transaction
    {
        return new Transaction($this->connection);
    }

    /**
     * Initialize account class and return it
     * @return Account
     */
    public function accounts(): Account
    {
        return new Account($this->connection);
    }
    
     /**

     * Create new customer and return it
     * @return Transaction
     */
    public function user(): SaltEdgeUser
    {
        return new SaltEdgeUser($this->connection);
    }
    
    /**

     * Create new category class and return it
     * @return Transaction
     */
    public function category(): Category
    {
        return new Category($this->connection);
    }

    /**
     * Create new provider class and return it
     * @return Provider
     */
    public function provider(): Provider
    {
        return new Provider($this->connection);
    }
    
    /**
     * Close connection with API
     */
    public function terminate()
    {
        $this->connection->shutdown();
    }

}