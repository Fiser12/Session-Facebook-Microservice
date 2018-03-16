<?php

namespace Behat;

use Behat\Behat\Context\Context;
use GuzzleHttp\Client;

class ApiJWTContext implements Context
{
    private $jwt;
    private $client;

    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    /**
     * @When /^I request (GET|PUT|POST|DELETE|PATCH) with JWT to "([^"]*)" in the cookie$/
     */
    public function sendRequestWithJWT($method, $url)
    {

    }
}
