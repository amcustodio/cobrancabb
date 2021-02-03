<?php namespace Ultrawave\CobrancaBB\Entities;

class AvalistaEntity
{
	public $tipoRegistro = 1;

	public $numeroRegistro = 0;

	public $nomeRegistro = '';

	public function getTipoRegistro()
	{
	    return $this->tipoRegistro;
	}

	public function setTipoRegistro($tipoRegistro)
	{
	    $this->tipoRegistro = $tipoRegistro;
	    return $this;
	}

	public function getNumeroRegistro()
	{
	    return $this->numeroRegistro;
	}

	public function setNumeroRegistro($numeroRegistro)
	{
	    $this->numeroRegistro = $numeroRegistro;
	    return $this;
	}

	public function getNomeRegistro()
	{
	    return $this->nomeRegistro;
	}

	public function setNomeRegistro($nomeRegistro)
	{
	    $this->nomeRegistro = $nomeRegistro;
	    return $this;
	}
}