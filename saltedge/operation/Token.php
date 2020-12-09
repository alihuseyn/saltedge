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
    const ENDPOINT_CREATE = 'connect_sessions/create';

    /**
     * @var  string token operation endpoint for reconnect
     */
    const ENDPOINT_RECONNECT = 'connect_sessions/reconnect';

    /**
     * @var  string token operation endpoint for refresh
     */
    const ENDPOINT_REFRESH = 'connect_sessions/refresh';

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
     * @see https://docs.saltedge.com/account_information/v5/#connect_sessions
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function connect(array $params): Token
    {
        $defaultParameters = [
               'customer_id' => '',     // Required
               'consent' => [
                  'scopes' => [
                    'account_details',
                    'transactions_details']],
                'return_connection_id' => true
        ];

        if (empty($params) || !isset($params['customer_id']) ||
                $params['customer_id'] == -1 || !is_int($params['customer_id'])) {
            throw new \Exception("Customer identifier can't be empty or null and identifier must be in numeric type");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_CREATE), $body);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
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
     * @see https://docs.saltedge.com/account_information/v5/#connect_sessions-reconnect
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function reconnect(array $params) : Token
    {
        $defaultParameters = [
            'connection_id' => '',     // Required
            'consent' => [
                  'scopes' => [
                    'account_details',
                    'transactions_details'
                  ]
                ],
            'return_connection_id' => true
        ];

        if (empty($params) || !isset($params['connection_id']) || empty($params['connection_id'])) {
            throw new \Exception("Connection identifier can't be empty or null and identifier must be defined.");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_RECONNECT), $body);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
    }

    /**
     * Allows you to create a token, which will be used to access Salt Edge Connect
     * to refresh a login. You will receive a connect_url field, which allows you to enter
     * directly to Salt Edge Connect with your newly generated token.
     *
     * @see https://docs.saltedge.com/account_information/v5/#connect_sessions-refresh
     * @param array $params Required parameters
     * @throws \Exception
     * @return Token
     */
    public function refresh(array $params) : Token
    {
        $defaultParameters = [
            'connection_id' => '',     // Required
            'consent' => [
                  'scopes' => [
                    'account_details',
                    'transactions_details'
                  ]
                ],
            'return_connection_id' => true,
        ];

        if (empty($params) || !isset($params['connection_id']) || empty($params['connection_id'])) {
            throw new \Exception("Connection identifier can't be empty or null and identifier must be defined.");
        }

        // Request Body
        $body = [ 'data' => array_replace($defaultParameters, $params) ];

        // Make request
        $raw = $this->connection->post($this->url(self::ENDPOINT_REFRESH), $body);
        $this->response = json_decode($raw, true);
        $this->triggerErrorIfAny();

        return $this;
    }
}
