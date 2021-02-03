<?php namespace Ultrawave\CobrancaBB\Entities;

class PagadorEntity
{
	public $tipoRegistro;

	public $numeroRegistro;

	public $nome;

	public $endereco;

	public $cep;

	public $cidade;

	public $bairro;

	public $uf;

	public $telefone;

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

	public function getNome()
	{
	    return $this->nome;
	}

	public function setNome($nome)
	{
	    $this->nome = $nome;
	    return $this;
	}

	public function getEndereco()
	{
	    return $this->endereco;
	}

	public function setEndereco($endereco)
	{
	    $this->endereco = $endereco;
	    return $this;
	}

	public function getCep()
	{
	    return $this->cep;
	}

	public function setCep($cep)
	{
	    $this->cep = $cep;
	    return $this;
	}

	public function getCidade()
	{
	    return $this->cidade;
	}

	public function setCidade($cidade)
	{
	    $this->cidade = $cidade;
	    return $this;
	}

	public function getBairro()
	{
	    return $this->bairro;
	}

	public function setBairro($bairro)
	{
	    $this->bairro = $bairro;
	    return $this;
	}

	public function getUf()
	{
	    return $this->uf;
	}

	public function setUf($uf)
	{
	    $this->uf = $uf;
	    return $this;
	}

	public function getTelefone()
	{
	    return $this->telefone;
	}

	public function setTelefone($telefone)
	{
	    $this->telefone = $telefone;
	    return $this;
	}
}
