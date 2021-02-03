<?php

namespace Ultrawave\CobrancaBB\Clients;


use Ultrawave\CobrancaBB\Exceptions\OAuthException;
use GuzzleHttp\Client;

/**
 * Class BancoDoBrasilAuthorizationClient
 * @package Ultrawave\CobrancaBB\Clients
 */
class BancoDoBrasilAuthorizationClient
{

	const OAUTH_HM = 'https://oauth.hm.bb.com.br/oauth/token';

	const OAUTH_PRODUCTION = 'https://oauth.bb.com.br/oauth/token';

    const SCOPE_REGISTRO = 'cobranca.registro-boletos'; # type = 1
    const SCOPE_REQUISICAO = 'cobrancas.boletos-requisicao'; #type = 2
    const SCOPE_INFO = 'cobrancas.boletos-info'; # type = 3

    private $scope;

	const GRANT_TYPE = 'client_credentials';

    /**
     * @var Client
     */
	private $httpClient;

    /**
     *
     * Constructor method
     * @param array $config
     */
	function __construct(array $config)
	{
		$this->httpClient = new Client();
        switch ($config['type']) {
            case 1:
                $this->scope = self::SCOPE_REGISTRO;
                break;
            case 2:
                $this->scope = self::SCOPE_REQUISICAO;
                break;
            default:
                $this->scope = self::SCOPE_INFO;
                break;
        }
		$this->clientId = array_get($config, 'clientId', null);
		$this->clientSecret = array_get($config, 'clientSecret', null);
		$this->oAuthUrl = array_get($config, 'production', false) == false? self::OAUTH_HM : self::OAUTH_PRODUCTION;
	}

    /**
     * @return bool
     */
	public function __callBancoDoBrasil()
	{
		return $this->__authorize();
	}

    /**
     * @return bool
     * @throws OAuthException
     */
    private function __authorize()
    {
        try {
            $responseOauth = $this->httpClient->post($this->oAuthUrl, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic '.base64_encode($this->clientId . ':' . $this->clientSecret)
                ],
                'form_params' => [
                    'scope' => $this->scope,
                    'grant_type' => self::GRANT_TYPE
                ]
            ]);

            $oauth = json_decode($responseOauth->getBody());
            if ($oauth && !empty($oauth->access_token)) {
              	return $oauth;
            }
        } catch(\Exception $e) {
			throw new OAuthException();
        }
        throw new OAuthException();
    }
}
