<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */

require '../vendor/autoload.php';

use Ultrawave\CobrancaBB\BancoDoBrasil;
use Ultrawave\CobrancaBB\Constants\TipoDocumento;
use Ultrawave\CobrancaBB\Entities\PagadorEntity;
use Ultrawave\CobrancaBB\Entities\BeneficiarioEntity;
use Ultrawave\CobrancaBB\Entities\InstrucoesEntity;
use Ultrawave\CobrancaBB\Entities\MultaEntity;
use Ultrawave\CobrancaBB\Entities\DescontoEntity;
use Ultrawave\CobrancaBB\Entities\AvalistaEntity;
use Ultrawave\CobrancaBB\Requests\BoletoRequest;
use Ultrawave\CobrancaBB\Helpers\Functions;

if (!isset($_REQUEST['fatura_id']) || strlen(trim($_REQUEST['fatura_id'])) == 0) {
	exit(json_encode([
		'status' => false,
		'message' => 'Informe o numero da fatura.',
		'data' => []
	]));
}
$fatura_id = $_REQUEST['fatura_id'];

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'eyJpZCI6IjEwNTBlNDctYWM1NyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9',
	'clientSecret' => 'eyJpZCI6ImFiYWY3OTEtZjIzOS00ZDgzLThjNmMtNTU3ODM0NWFjNTZkZjlmYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjAwOTcxODIzMDU4fQ',
	'production' => true,
	'app_key' => '7091508b0affbe20136ae18190050e56b991a5b9',
	'type' => 2
]);


$functions = new Functions();
$dados = $functions->getDadosFatura($fatura_id);

$pagador = new PagadorEntity;
$pagador->setTipoRegistro($dados->pessoa)
	->setNumeroRegistro($dados->documento)
	->setNome(substr(trim($dados->nome), 0, 60))
	->setEndereco(substr(trim($dados->endereco), 0, 60))
	->setCep(substr(str_replace('-', '', trim($dados->cep)), 0, 8))
	->setCidade(substr(trim($dados->cidade), 0, 20))
	->setBairro(substr(trim($dados->bairro), 0, 20))
	->setUf(trim($dados->estado));
	//->setTelefone();
$boletoRequest = new BoletoRequest();

// $avalista = new AvalistaEntity();
// $avalista->setTipoRegistro(TipoDocumento::CPF)
// 	->setNumeroRegistro(71128590182)
// 	->setNomeRegistro('Alfredão da ultrawave');

$boletoRequest->setNumeroConvenio($dados->convenio)
	->setNumeroCarteira($dados->carteira)
	->setnumeroVariacaoCarteira($dados->variacao)
	->setDataEmissao(date('Y-m-d'))
	->setDataVencimento($dados->vencimento)
	->setValorOriginal(str_replace([','], '', trim($dados->valor)))
	->setDescricaoTipoTitulo("")
	->setNumeroTituloBeneficiario($dados->numfatura)
	->setTextoCampoUtilizacaoBeneficiario('')
	->setNumeroTituloCliente('000' . $dados->nossonumero)
	->setPagador($pagador);
	// ->setAvalista($avalista);
	//->setBeneficiario((array)$beneficiario);
//dd(json_encode($boletoRequest));
//dd($boletoRequest);
$data = $bancoDoBrasil->register($boletoRequest);
echo json_encode($data);
exit();