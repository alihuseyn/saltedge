<?php

namespace SaltEdge\Operation;

use Carbon\Carbon;
use SaltEdge\Request\SaltEdge;

/**
 * Class Token
 * We use tokens to identify clients who will use Salt Edge Connect.
 * With a token, you will be able to let your users connect, reconnect or refresh a login.
 * Note that the token will expire in 60 seconds if you do not access Salt Edge Connect.
 * After the token has been used to redirect the user to Salt Edge Connect,
 * the user will have 10 minutes to fill in the necessary data. Afterwards, the user’s session will expire.
 * @package SaltEdge\Operation
 */
class Token extends Operation
{
    /**
     * @var string token operation endpoint for create
     */
    const ENDPOINT_CREATE = 'tokens/create';

    /**
     * @var  string token operation endpoint for reconnect
     */
    const ENDPOINT_RECONNECT = 'tokens/reconnect';

    /**
     * @var  string token operation endpoint for refresh
     */
    const ENDPOINT_REFRESH = 'tokens/refresh';

    /**
     * Constructor
     * @param SaltEdge $connection Connection information
     */
    public function __construct(SaltEdge $connection)
    {
        parent::__construct($connection);
    }

    /**
     * Allows you to create a token, which will be used to access Salt Edge Connect for login creation.
     * You will receive a connect_url field, which allows you to enter directly to Salt Edge Connect
     * with your newly generated token. Explanation of parameters are as below:
     *
     * @see https://docs.saltedge.com/account_information/v4/#tokens-create
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function connect(array $params): Token
    {
        $defaultParameters = [
            'customer_id' => -1,     // Required
            'allowed_countries' => ["TR"],
            'fetch_scopes' => [ 'accounts', 'transactions' ],
            'fetched_accounts_notify' => true,
            'disable_provider_search' => false,
            'to_date' => Carbon::now()->toDateString(),
            'locale' => 'tr',
            'return_login_id' => true,
            'javascript_callback_type' => 'post_message',
            'include_fake_providers' => false,
            'lost_connection_notify' => true,
            'credentials_strategy' => 'store'
        ];

        if (empty($params) || !isset($params['customer_id']) || $params['customer_id'] == -1 || !is_int($params['customer_id'])) {
            throw new \Exception("Customer identifier can't be empty or null and identifier must be in numeric type");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_CREATE), $body);
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }

    /**
     * Call connect function with configured parameters
     * It is used for simplified and fast access to connect function
     * @param $clientId
     * @return Token
     * @throws \Exception
     */
    public function connectWithClientId($clientId) : Token
    {
        return $this->connect(['client_id' => $clientId]);
    }

    /**
     * Redirect user to the token page after operation
     * or throw exception if connect_url is not set on response
     * @throws \Exception
     */
    public function redirect()
    {
        if (!empty($this->response) && isset($this->response['data']['connect_url'])) {
            header("Location: {$this->response['data']['connect_url']}");
            return;
        }

        throw new \Exception("Connect URL is not set for redirection");
    }

    /**
     * Allows you to create a token, which will be used to access 
     * Salt Edge Connect to reconnect a login. You will receive a connect_url field, 
     * which allows you to enter directly to Salt Edge Connect with your newly generated token.
     *
     * @see https://docs.saltedge.com/account_information/v4/#tokens-reconnect
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function reconnect(array $params) : Token
    {
        $defaultParameters = [
            'login_id' => '',     // Required
            'fetch_scopes' => [ 'accounts', 'transactions' ],
            'fetched_accounts_notify' => true,
            'to_date' => Carbon::now()->toDateString(),
            'locale' => 'tr',
            'return_login_id' => true,
            'javascript_callback_type' => 'post_message',
            'lost_connection_notify' => true,
            'credentials_strategy' => 'store'
        ];  

        if (empty($params) || !isset($params['login_id']) || empty($params['login_id'])) {
            throw new \Exception("Login identifier can't be empty or null and identifier must be defined.");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_RECONNECT), $body);
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }

    /**
     * Call reconnect function with configured parameters
     * It is used for simplified and fast access to reconnect function
     * @param $loginId
     * @return Token
     * @throws \Exception
     */
    public function reconnectWithLoginId($loginId) : Token
    {
        return $this->reconnect(['login_id' => $loginId]);
    }

    /**
     * Allows you to create a token, which will be used to access Salt Edge Connect 
     * to refresh a login. You will receive a connect_url field, which allows you to enter 
     * directly to Salt Edge Connect with your newly generated token.
     *
     * @see https://docs.saltedge.com/account_information/v4/#tokens-refresh
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function refresh(array $params) : Token
    {
        $defaultParameters = [
            'login_id' => '',     // Required
            'fetch_scopes' => [ 'accounts', 'transactions' ],
            'fetched_accounts_notify' => true,
            'to_date' => Carbon::now()->toDateString(),
            'locale' => 'tr',
            'return_login_id' => true,
            'javascript_callback_type' => 'post_message',
            'lost_connection_notify' => true,
            'credentials_strategy' => 'store'
        ];  

        if (empty($params) || !isset($params['login_id']) || empty($params['login_id'])) {
            throw new \Exception("Login identifier can't be empty or null and identifier must be defined.");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_REFRESH), $body);
        $this->response = json_decode($raw, true);

        // Check for error response
        if (isset($this->response['error_class'])) {
            throw new \Exception("[{$this->response['error_class']}]  {$this->response['error_message']}");
        }

        return $this;
    }

    /**
     * Call refresh function with configured parameters
     * It is used for simplified and fast access to refresh function
     * @param $loginId
     * @return Token
     * @throws \Exception
     */
    public function refreshWithLoginId($loginId) : Token
    {
        return $this->refresh(['login_id' => $loginId]);
    }
}
