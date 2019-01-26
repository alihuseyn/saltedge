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
     * Token constructor.
     * @param SaltEdge $connection
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
     *  - customer_id (string, required) - the ID of the customer received from customer create
     *  - allowed_countries (array of strings, optional) - the list of countries that will be accessible in Salt Edge Connect, defaults to null
     *  - provider_code (string, optional) - the code of the desired provider, defaults to null
     *  - fetch_scopes (array of strings, required) - fetching mode,
     *    possible values: ['accounts'], ['holder_info'], ['accounts', 'holder_info'], ['accounts', 'transactions'], ['accounts', 'holder_info', 'transactions']
     *  - fetched_accounts_notify (boolean, optional) - whether Salt Edge should send a success callback after fetching accounts. Defaults to false
     *  - identify_merchant (boolean, optional) - whether merchant identification should be applied. Defaults to false
     *  - customer_last_logged_at (datetime, optional) - the datetime when user was last active in your application
     *  - custom_fields (object, optional) - a JSON object, which will be sent back on any of your callbacks
     *  - daily_refresh (boolean, optional) - whether the login should be automatically refreshed by Salt Edge
     *  - disable_provider_search (boolean, optional) - whether the provider search will be disabled, works only if provider_code parameter is sent. Defaults to false
     *  - from_date (date, optional) - date from which you want to fetch data for your login.
     *      Note: The usage of this parameter is only available when fetch_scopes parameter contains transactions, otherwise InvalidFromDate error will be returned.
     *      The allowed values for this parameter must be within exactly 2 months ago and tomorrow.
     *  - to_date (date, optional) - date until which you want to fetch data for your login.
     *  - locale (string, optional) - the language of the Salt Edge Connect page in the ISO 639-1 format.
     *  - return_to (string, optional) - the URL the user will be redirected to, defaults to client’s home URL
     *  - return_login_id (boolean, optional) - whether to append login_id to return_to URL. Defaults to false
     *  - provider_modes (array of strings, optional) - restrict the list of the providers to only the ones that have the mode included in the array.
     *  - categorization (string, optional) - the type of categorization applied. Possible values: none, personal, business. Default: personal
     *  - javascript_callback_type (string, optional) - allows you to specify what kind of callback type you are expecting .Possible values: iframe, external_saltbridge, external_notify, post_message
     *  - include_fake_providers (boolean, optional) Defaults to false
     *  - lost_connection_notify - (boolean, optional) being sent as true, enables you to receive a javascript callback whenever the internet connection
     *      is lost during the fetching process. The type of the callback depends on the javascript_callback_type you specified.
     *  - show_consent_confirmation (boolean, optional)
     *  - consent_period_days (integer, optional)
     *  - credentials_strategy (string, optional) - the strategy of storing customers credentials. Possible values: store, do_not_store, ask. Default value: store.
     *  - include_natures (array of strings, optional) - the natures of the accounts that need to be fetched. Check accounts attributes for possible values. Default value: null (all accounts will be fetched)
     *
     * @see https://docs.saltedge.com/reference/#tokens
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

    public function refresh()
    {
        // TODO: Implementation
    }
}