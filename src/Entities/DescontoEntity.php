<?php

namespace Ultrawave\CobrancaBB\Entities;

use Ultrawave\CobrancaBB\Constants\Desconto;
use Ultrawave\CobrancaBB\Helpers\BancoDoBrasil as BancoDoBrasilHelper;

class DescontoEntity
{
	public $tipo = Desconto::SEM_DESCONTO;

	private $dataExpiracao;

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

	public function getDataExpiracao()
	{
	    return $this->dataExpiracao;
	}

	public function setDataExpiracao($dataExpiracao)
	{
	    $this->dataExpiracao = BancoDoBrasilHelper::generateDateTimeFromBoleto($dataExpiracao);
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
	    $this->valor = $valor;
	    return $this;
	}

}

