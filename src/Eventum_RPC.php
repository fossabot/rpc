<?php

/*
 * This file is part of the Eventum (Issue Tracking System) package.
 *
 * @copyright (c) Eventum Team
 * @license GNU General Public License, version 2 or later (GPL-2+)
 *
 * For the full copyright and license information,
 * please see the COPYING and AUTHORS files
 * that were distributed with this source code.
 */

class Eventum_RPC_Exception extends Exception
{
}

class Eventum_RPC
{
    const VERSION = '4.1.1';

    /** @var PhpXmlRpc\Client */
    private $client;

    /** @var PhpXmlRpc\Encoder */
    private $encoder;

    public function __construct($url)
    {
        $this->client = new PhpXmlRpc\Client($url);
        $this->encoder = new PhpXmlRpc\Encoder();

        $this->addUserAgent('EventumRPC/' . self::VERSION);
    }

    /**
     * Change the current debug mode
     *
     * @param int $debug where 1 = on, 0 = off
     */
    public function setDebug($debug)
    {
        $this->client->setDebug($debug);
    }

    /**
     * Set username and password properties for connecting to the RPC server
     *
     * @param string $username the user name
     * @param string $password the password
     */
    public function setCredentials($username, $password)
    {
        $this->client->setCredentials($username, $password);
    }

    /**
     * Implementation independent method to encode value as binary
     *
     * @param mixed $value
     * @return \PhpXmlRpc\Value
     * @since 3.0.1
     */
    public function encodeBinary($value)
    {
        return new PhpXmlRpc\Value($value, 'base64');
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws Eventum_RPC_Exception
     */
    public function __call($method, $args = array())
    {
        $params = array();
        foreach ($args as $arg) {
            // argument already encoded, perhaps via encodeBinary
            if ($arg instanceof PhpXmlRpc\Value) {
                $params[] = $arg;
                continue;
            }

            // serialize all objects first
            if (is_object($arg)) {
                $arg = serialize($arg);
            }

            $params[] = $this->encoder->encode($arg);
        }

        $req = new PhpXmlRpc\Request($method, $params);
        $result = $this->client->send($req);

        if ($result === 0) {
            throw new Eventum_RPC_Exception($this->client->errstr);
        }
        if (is_object($result) && $result->faultCode()) {
            throw new Eventum_RPC_Exception($result->faultString());
        }

        return $this->encoder->decode($result->value());
    }

    /**
     * Add identifier to user agent
     *
     * @param string $userAgent
     */
    public function addUserAgent($userAgent)
    {
        $this->client->user_agent .= ' ' . $userAgent;
    }
}
