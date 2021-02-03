<?php

namespace Ultrawave\CobrancaBB\Services;

use Ultrawave\CobrancaBB\Entities\OAuthEntity;
use Ultrawave\CobrancaBB\Clients\BancoDoBrasilAuthorizationClient;
/**
*
*
*
*/
class ServiceAuthorization
{
	public function authorize(array $config)
	{
		$authorize = (new BancoDoBrasilAuthorizationClient($config))
			->__callBancoDoBrasil();
		$oAuthEntity = new OAuthEntity;
		$oAuthEntity->setAccessToken($authorize->access_token)
		    ->setEnvironment(array_get($config, 'production', $config['production']))
            ->setAppKey(isset($config['app_key'])? $config['app_key'] : null);

		return $oAuthEntity;
	}
}
