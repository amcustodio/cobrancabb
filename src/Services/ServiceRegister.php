<?php

namespace Ultrawave\CobrancaBB\Services;

use StdClass;
use Ultrawave\CobrancaBB\Entities\OAuthEntity;
use Ultrawave\CobrancaBB\Entities\InstrucoesEntity;
use Ultrawave\CobrancaBB\Entities\PagadorEntity;
use Ultrawave\CobrancaBB\Entities\BeneficiarioEntity;
use Ultrawave\CobrancaBB\Exceptions\PagadorException;
use Ultrawave\CobrancaBB\Exceptions\BoletoException;
use Ultrawave\CobrancaBB\Exceptions\BeneficiarioException;
use Ultrawave\CobrancaBB\Factories\BoletoResponseFactory;
use Ultrawave\CobrancaBB\Requests\BoletoRequest;
use Ultrawave\CobrancaBB\Responses\BoletoResponse;
use Ultrawave\CobrancaBB\Http\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

/**
*
*
*
*/
class ServiceRegister
{

	/**
	*
	* @var Ultrawave\CobrancaBB\Soap\Factories\BoletoFactory
	*/
	private $boletoFactory;

	/**
	*
	* @var Ultrawave\CobrancaBB\Factories\BoletoResponseFactory
	*/
	private $boletoResponseFactory;

	private $httpClient;

	/**
		*
	* @param Ultrawave\CobrancaBB\Soap\Factories\BoletoFactory
	*/
	function __construct()
	{
		$this->httpClient = new Client;
	}

	/**
	*
	* Verify Error
	* @param [StdClass]
	*/
	private function verifyExistsError(StdClass $error)
	{
		if(!empty(trim($error->nomeProgramaErro)))
			throw new BoletoException($error->textoMensagemErro);
	}


	/**
	*
	* @param Ultrawave\CobrancaBB\Requests\BoletoRequest
	* @param Ultrawave\CobrancaBB\Entities\OAuthEntity
	*/
	public function register(BoletoRequest $boletoRequest, OAuthEntity $oAuthEntity)
	{
		$boletoRequest =  json_encode($boletoRequest);
		try {
			$endpoint = $oAuthEntity->getEnvironment() == false? Config::ENDPOINT_HM . '/boletos' : Config::ENDPOINT_PRODUCTION . '/boletos';
			$response = $this->httpClient->post($endpoint, [
				'query' => [
					'gw-dev-app-key' => $oAuthEntity->getAppKey()
				],
				RequestOptions::JSON => json_decode($boletoRequest),
                'headers' => [
                    'Authorization' => 'Bearer '. $oAuthEntity->getAccessToken()
                ],
			]);
			$bodyResponse = $response->getBody()->getContents();

			return [
				'status' => true,
				'message' => 'Fatura registrada com scesso!',
				'data' => json_decode($bodyResponse)
			];

		} catch (RequestException $e) {
			return [
				'status' => false,
				'message' => $e->getMessage(),
				'data' => $e
			];
		}
	}
}
