<?php namespace Ultrawave\CobrancaBB\Entities;

use Ultrawave\CobrancaBB\Constants\Multa;
use Ultrawave\CobrancaBB\Helpers\BancoDoBrasil as BancoDoBrasilHelper;


class MultaEntity
{
	public $tipo = Multa::DISPENSAR;

	private $data;

	private $porcentagem;

	private $valor;

	public function getTipo()
	{
	    return $this->tipo;
	}

	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	    return $this;
	}

	public function getData()
	{
	    return $this->data;
	}

	public function setData($data)
	{
	    $this->data = BancoDoBrasilHelper::generateDateTimeFromBoleto($data);
	    return $this;
	}

	public function getPorcentagem()
	{
	    return $this->porcentagem;
	}

	public function setPorcentagem($porcentagem)
	{
	    $this->porcentagem = $porcentagem;
	    return $this;
	}

	public function getValor()
	{
	    return $this->valor;
	}

	public function setValor($valor)
	{
	    $this->valor = BancoDoBrasilHelper::formatMoney($valor);
	    return $this;
	}
}