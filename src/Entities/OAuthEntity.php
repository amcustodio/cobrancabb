<?php

namespace Ultrawave\CobrancaBB\Entities;

/**
 * Class OAuthEntity
 * @package Ultrawave\CobrancaBB\Entities
 */
class OAuthEntity
{
    /**
     * @var
     */

	private $typeToken;
    /**
     * @var
     */
	private $accessToken;

    /**
     * @var
     */
	private $environment;

    /**
     * @var
     */
    private $app_key;
    /**
     * @return mixed
     */
	public function getTypeToken()
	{
	    return $this->typeToken;
	}

    /**
     * @param $typeToken
     * @return $this
     */
	public function setTypeToken($typeToken)
	{
	    $this->typeToken = $typeToken;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getAccessToken()
	{
	    return $this->accessToken;
	}

    /**
     * @param $accessToken
     * @return $this
     */
	public function setAccessToken($accessToken)
	{
	    $this->accessToken = $accessToken;
	    return $this;
	}

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param $environment
     * @return $this
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @param $app_key
     * @return $this
     */
    public function setAppKey($app_key)
    {
        $this->app_key = $app_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->app_key;
    }

}