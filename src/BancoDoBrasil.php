<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */
namespace Ultrawave\CobrancaBB;

use Ultrawave\CobrancaBB\Constants\Formato;
use Ultrawave\CobrancaBB\Exceptions\BoletoException;
use Ultrawave\CobrancaBB\Helpers\Fractal;
use Ultrawave\CobrancaBB\Requests\BoletoRequest;
use Ultrawave\CobrancaBB\Responses\BoletoResponse;
use Ultrawave\CobrancaBB\Services\ServiceAuthorization;
use Ultrawave\CobrancaBB\Services\ServiceRegister;
use Ultrawave\CobrancaBB\Services\ServiceListing;
use Ultrawave\CobrancaBB\Services\ServiceLayoutBoleto;
use Ultrawave\CobrancaBB\Transformers\BoletoTransformer;
use Ultrawave\CobrancaBB\Validates\BancoDoBrasilValidate;

/**
 * Class BancoDoBrasil
 * @package Ultrawave/CobrancaBB
 */
class BancoDoBrasil
{
    /**
     * @var Entities\OAuthEntity
     */
	private $authorization;

    /**
     * @var array
     */
	private $config;

	/**
	*
	* @param [array|config]
	* @return bool
	*/
  	function __construct(array $config)
	{
		$bancoDoBrasilValidate = new BancoDoBrasilValidate();
		$bancoDoBrasilValidate->config($config);

		$this->config = $config;

		$serviceAuthorization = new ServiceAuthorization();
		$this->authorization = $serviceAuthorization->authorize($config);
	}

    /**
     * @param BoletoRequest $boletoRequest
     * @return mixed
     * @throws BoletoException
     */
	public function register(BoletoRequest $boletoRequest)
	{
    	$serviveRegister = new ServiceRegister();
	   	return $serviveRegister->register($boletoRequest, $this->authorization);;
	}


    /**
     * Recupera dados de uma fatura especificamente
     * @param  int $fatura_id
     * @return Object<DadosFatura>
     */
    public function get($fatura_id)
    {
        $serviceListing = new ServiceListing();
        return $serviceListing->get($fatura_id, $this->authorization);
    }
}