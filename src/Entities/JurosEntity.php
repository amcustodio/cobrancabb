<?php namespace Ultrawave\CobrancaBB\Entities;

use Ultrawave\CobrancaBB\Constants\Juros;
use Ultrawave\CobrancaBB\Helpers\BancoDoBrasil as BancoDoBrasilHelper;

/**
 * Class JurosEntity
 * @package Ultrawave\CobrancaBB\Entities
 */
class JurosEntity
{
    /**
     * @var int
     */
	public $tipo = Juros::NAO_INFORMADO;

    /**
     * @var
     */
	public $porcentagem;

    /**
     * @var
     */
	public $valor;

    /**
     * @return int
     */
	public function getTipo()
	{
	    return $this->tipo;
	}

    /**
     * @param $tipo
     * @return $this
     */
	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getPorcentagem()
	{
	    return $this->porcentagem;
	}

    /**
     * @param $percentual
     * @return $this
     */
	public function setPorcentagem($porcentagem)
	{
	    $this->porcentagem = $porcentagem;
	    return $this;
	}

    /**
     * @return mixed
     */
	public function getValor()
	{
	    return $this->valor;
	}

    /**
     * @param $valor
     * @return $this
     */
	public function setValor($valor)
	{
	    $this->valor = BancoDoBrasilHelper::formatMoney($valor);
	    return $this;
	}

}