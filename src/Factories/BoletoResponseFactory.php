<?php

namespace Ultrawave\CobrancaBB\Factories;

use StdClass;
use Ultrawave\CobrancaBB\Requests\BoletoRequest;
use Ultrawave\CobrancaBB\Responses\BoletoResponse;

class BoletoResponseFactory
{
	/**
	*
	* @param Ultrawave\CobrancaBB\Requests\BoletoRequest
	* @param StdClass
	*/
	public function make(BoletoRequest $boletoRequest, StdClass $objectBoleto)
	{
		$logradouro = $boletoRequest->getBeneficiario()->getLogradouro();
		$municipio = $boletoRequest->getBeneficiario()->getMunicipio();
		$uf = $boletoRequest->getBeneficiario()->getUf();

		$response = new BoletoResponse;
		$response->setNossoNumero($boletoRequest->getNossoNumero())
			->setInicioNossoNumero('000')
			->setNumeroDocumento($boletoRequest->getNossoNumero())
			->setVencimento($boletoRequest->getDataVencimento()->format('d/m/Y'))
			->setEmissao($boletoRequest->getDataEmissao()->format('d/m/Y'))
			->setProcessamento($boletoRequest->getDataEmissao()->format('d/m/Y'))
			->setValor($boletoRequest->getValorOriginal())
			->setConvenio($boletoRequest->getConvenio())
			->setCarteira($boletoRequest->getCarteira())
			->setVariacaoCarteira($boletoRequest->getVariacaoCarteira())
			->setPagador($boletoRequest->getPagador())
			->setDemonstrativo($boletoRequest->getDescricaoTipoTitulo())
			->setInstrucoes($boletoRequest->getInstrucoes())
			->setAceite($boletoRequest->getAceite())
			->setAgencia($objectBoleto->codigoPrefixoDependenciaBeneficiario)
			->setConta($objectBoleto->numeroContaCorrenteBeneficiario)
			->setContaDigito('0')
			->setNomeBeneficiario($boletoRequest->getBeneficiario()->getNome())
			->setDocumento($boletoRequest->getBeneficiario()->getDocumento())
			->setEndereco($logradouro?$logradouro:$objectBoleto->nomeLogradouroBeneficiario)
			->setCidade($municipio?$municipio:$objectBoleto->nomeMunicipioBeneficiario)
			->setUf($uf? $uf:$objectBoleto->siglaUfBeneficiario);

		return $response;
	}
}