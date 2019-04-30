<?php

namespace SaltEdge\Traits;

trait HasPagination
{
    /**
     * Return current page data from response.
     * Successful response will look like below:
     * <code>
     * {
     *   data: [...],
     *   meta: {
     *       next_id: <id_of_next_page>,
     *       next_page": <url_of_next_page> (/api/v4/transactions/....)
     * }
     * </code>
     * @return array current page response over data
     */
    public function data():array
    {
        $response = $this->response();
        return !is_null($response) ? ($response['data'] ?? []) : array();
    }

    /**
     * Retrieve next available page body with get request and set it to the
     * response for usage. If the next page is not exists or null
     * @return mixed|SaltEdge\Operation\Operation null or class itself with new response
     */
    public function next()
    {
        $response = $this->response();
        if (!empty($response)) {
            if (isset($response['meta'])) {
                // Set Next Page
                $nextPage = $response['meta']['next_page'];
                if (!empty($nextPage)) {
                    // Remove /api/v4 part according to
                    // the version of api and generate endpoint
                    $nextPage = end($nextPage.split(self::API_VERSION));
                    $url = $this->url($nextPage);

                    $raw = $this->connection->get($url);
                    $this->response = json_decode($raw, true);
                    $this->triggerErrorIfAny();

                    return $this;
                }
            }
        }

        return null;
    }
}
