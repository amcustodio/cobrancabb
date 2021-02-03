<?php namespace Ultrawave\CobrancaBB\Requests;

use Ultrawave\CobrancaBB\Constants\AceiteTitulo;
use Ultrawave\CobrancaBB\Constants\Modalidade;
use Ultrawave\CobrancaBB\Constants\TipoTitulo;
use Ultrawave\CobrancaBB\Constants\RecebimentoParcial;
use Ultrawave\CobrancaBB\Entities\AvalistaEntity;
use Ultrawave\CobrancaBB\Entities\BeneficiarioEntity;
use Ultrawave\CobrancaBB\Entities\DescontoEntity;
use Ultrawave\CobrancaBB\Entities\InstrucoesEntity;
use Ultrawave\CobrancaBB\Entities\JurosEntity;
use Ultrawave\CobrancaBB\Entities\MultaEntity;
use Ultrawave\CobrancaBB\Entities\PagadorEntity;
use Ultrawave\CobrancaBB\Helpers\BancoDoBrasil as BancoDoBrasilHelper;

class BoletoRequest
{
	public $numeroConvenio;

	public $numeroCarteira;

	public $numeroVariacaoCarteira;

	public $codigoModalidade = Modalidade::SIMPLES; // Default

	public $dataEmissao;

	public $dataVencimento;

	public $valorOriginal;

	private $valorAbatimento = 0.00;

	public $quantidadeDiasProtesto = 0;

	public $indicadorNumeroDiasLimiteRecebimento = RecebimentoParcial::SIM;

	public $numeroDiasLimiteRecebimento = 365;

	public $codigoAceite = AceiteTitulo::NAO_ACEITE;

	public $codigoTipoTitulo = TipoTitulo::DUPLICATA_SERVICO;

	public $descricaoTipoTitulo = '';

	public $indicadorPermissaoRecebimentoParcial = RecebimentoParcial::NAO;

	public $numeroTituloBeneficiario;

	public $textoCampoUtilizacaoBeneficiario = 'aaaa';

	public $codigoTipoContaCaucao = 0;

	public $numeroTituloCliente;

	public $textoMensagemBloquetoOcorrencia = '';

	public $desconto;

	public $segundoDesconto;

	public $terceiroDesconto;

	public $jurosMora = [
		'tipo' => 0
	];


	public $multa;

	public $pagador;

	//public $avalista;

	public $email = '';
	public $quantidadeDiasNegativacao = 0;


	function __construct(){
		$this->desconto = new DescontoEntity();
		$this->segundoDesconto = new DescontoEntity();
		$this->terceiroDesconto = new DescontoEntity();

		$this->multa = new MultaEntity();
		//$this->avalista = new AvalistaEntity();
	}

	public function getNumeroConvenio()
	{
	    return $this->numeroConvenio;
	}

	public function setNumeroConvenio($numeroConvenio)
	{
	    $this->numeroConvenio = $numeroConvenio;
	    return $this;
	}

	public function getNumeroCarteira()
	{
	    return $this->numeroCarteira;
	}

	public function setNumeroCarteira($numeroCarteira)
	{
	    $this->numeroCarteira = $numeroCarteira;
	    return $this;
	}

	public function getNumeroVariacaoCarteira()
	{
	    return $this->numeroVariacaoCarteira;
	}

	public function setNumeroVariacaoCarteira($numeroVariacaoCarteira)
	{
	    $this->numeroVariacaoCarteira = $numeroVariacaoCarteira;
	    return $this;
	}

	public function getCodigoModalidade()
	{
	    return $this->codigoModalidade;
	}

	public function setCodigoModalidade($codigoModalidade)
	{
	    $this->modalidade = $codigoModalidade;
	    return $this;
	}

	public function getDataEmissao()
	{
	    return $this->dataEmissao;
	}

	public function setDataEmissao($dataEmissao)
	{
	    $this->dataEmissao = BancoDoBrasilHelper::generateDateTimeFromBoleto($dataEmissao);
	    return $this;
	}

	public function getDataVencimento()
	{
	    return $this->dataVencimento;
	}

	public function setDataVencimento($dataVencimento)
	{
	    $this->dataVencimento = BancoDoBrasilHelper::generateDateTimeFromBoleto($dataVencimento);
	    return $this;
	}

	public function getValorOriginal()
	{
	    return $this->valorOriginal;
	}

	public function setValorOriginal($valorOriginal)
	{
	    $this->valorOriginal = BancoDoBrasilHelper::formatMoney($valorOriginal);
	    return $this;
	}

	public function getDesconto()
	{
	    return $this->desconto;
	}

	public function setDesconto($desconto)
	{
	    $this->desconto = $desconto;
	    return $this;
	}

	public function getQuantidadeDiasProtesto()
	{
	    return $this->quantidadeDiasProtesto;
	}

	public function setQuantidadeDiasProtesto($quantidadeDiasProtesto)
	{
	    $this->quantidadeDiasProtesto = $quantidadeDiasProtesto;
	    return $this;
	}

	public function getJurosMora()
	{
	    return $this->jurosMora;
	}

	public function setJurosMora(JurosEntity $jurosMora)
	{
	    $this->jurosMora = $jurosMora;
	    return $this;
	}

	public function getMulta()
	{
	    return $this->multa;
	}

	public function setMulta($multa)
	{
	    $this->multa = $multa;
	    return $this;
	}

	public function getCodigoAceite()
	{
	    return $this->codigoAceite;
	}

	public function setCodigoAceite($codigoAceite)
	{
	    $this->codigoAceite = $codigoAceite;
	    return $this;
	}

	public function getCodigoTipoTitulo()
	{
	    return $this->codigoTipoTitulo;
	}

	public function setCodigoTipoTitulo($codigoTipoTitulo)
	{
	    $this->codigoTipoTitulo = $codigoTipoTitulo;
	    return $this;
	}

	public function getDescricaoTipoTitulo()
	{
	    return $this->descricaoTipoTitulo;
	}

	public function setDescricaoTipoTitulo($descricaoTipoTitulo)
	{
	    $this->descricaoTipoTitulo = $descricaoTipoTitulo;
	    return $this;
	}

	public function getIndicadorNumeroDiasLimiteRecebimento()
	{
	    return $this->indicadorNumeroDiasLimiteRecebimento;
	}

	public function setIndicadorNumeroDiasLimiteRecebimento($indicadorNumeroDiasLimiteRecebimento)
	{
	    $this->indicadorNumeroDiasLimiteRecebimento = $indicadorNumeroDiasLimiteRecebimento;
	    return $this;
	}

	public function getNumeroTituloBeneficiario()
	{
	    return $this->numeroTituloBeneficiario;
	}

	public function setNumeroTituloBeneficiario($numeroTituloBeneficiario)
	{
	    $this->numeroTituloBeneficiario = $numeroTituloBeneficiario;
	    return $this;
	}

	public function getTextoCampoUtilizacaoBeneficiario()
	{
	    return $this->textoCampoUtilizacaoBeneficiario;
	}

	public function setTextoCampoUtilizacaoBeneficiario($textoCampoUtilizacaoBeneficiario)
	{
	    $this->textoCampoUtilizacaoBeneficiario = $textoCampoUtilizacaoBeneficiario;
	    return $this;
	}

	public function getCodigoTipoContaCaucao()
	{
	    return $this->codigoTipoContaCaucao;
	}

	public function setCodigoTipoContaCaucao($codigoTipoContaCaucao)
	{
	    $this->codigoTipoContaCaucao = $codigoTipoContaCaucao;
	    return $this;
	}

	public function getNumeroTituloCliente()
	{
	    return $this->numeroTituloCliente;
	}

	public function setNumeroTituloCliente($numeroTituloCliente)
	{
	    $this->numeroTituloCliente = $numeroTituloCliente;
	    return $this;
	}

	public function getInstrucoes()
	{
	    return $this->instrucoes;
	}

	public function setInstrucoes($instrucoes)
	{
	    $this->instrucoes = $instrucoes;
	    return $this;
	}

	public function getPagador()
	{
	    return $this->pagador;
	}

	public function setPagador($pagador)
	{
	    $this->pagador = $pagador;
	    return $this;
	}

	public function getAvalista()
	{
	    return $this->avalista;
	}

	// public function setAvalista($avalista)
	// {
	//     $this->avalista = $avalista;
	//     return $this;
	// }

	public function getBeneficiario()
	{
	    return $this->beneficiario;
	}

	public function setBeneficiario($beneficiario)
	{
	    $this->beneficiario = $beneficiario;
	    return $this;
	}

	public function getValorAbatimento()
	{
	    return $this->valorAbatimento;
	}

	public function setValorAbatimento($valorAbatimento)
	{
	    $this->valorAbatimento = $valorAbatimento;
	    return $this;
	}

	public function setNumeroDiasLimiteRecebimento($numeroDiasLimiteRecebimento)
	{
		$this->numeroDiasLimiteRecebimento = $numeroDiasLimiteRecebimento;
		return $this;
	}

	public function getNumeroDiasLimiteRecebimento()
	{
		return $this->numeroDiasLimiteRecebimento;
	}
}