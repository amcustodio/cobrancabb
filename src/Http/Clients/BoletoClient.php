<?php

namespace Ultrawave\CobrancaBB\Http\Clients;

use Ultrawave\CobrancaBB\Entities\OAuthEntity;


class BoletoClient extends Client
{

    /**
     * @var HttpClient
     */
    public $endpoint;

    /**
     * $oAuthEntity
     * @var OAuthEntity
     */
    private $oAuthEntity;

    /**
     * BoletoClient constructor.
     * @param OAuthEntity $oAuthEntity
    */
	function __construct(OAuthEntity $oAuthEntity)
	{


        parent::__construct([
            'base_uri' => $endpoint,
        ]);
	}
}