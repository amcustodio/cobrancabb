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

$bancoDoBrasil = new BancoDoBrasil([
    'clientId' => 'eyJpZCI6IjEwNTBlNDctYWM1NyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9',
    'clientSecret' => 'eyJpZCI6ImFiYWY3OTEtZjIzOS00ZDgzLThjNmMtNTU3ODM0NWFjNTZkZjlmYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjAwOTcxODIzMDU4fQ',
    'production' => true,
    'app_key' => '7091508b0affbe20136ae18190050e56b991a5b9',
    'type' => 2
]);


$fim = $argv[1];

$functions = new Functions();
$faturas = $functions->getFaturas('2020-10-01', $fim);
foreach ($faturas as $dados) {
    $pagador = new PagadorEntity;
    $pagador->setTipoRegistro($dados->pessoa)
        ->setNumeroRegistro($dados->documento)
        ->setNome(substr(trim(iconv('UTF-8', 'UTF-8//IGNORE',$dados->nome)), 0, 60))
        ->setEndereco(substr(trim(iconv('UTF-8', 'UTF-8//IGNORE',str_replace("\t", '', $dados->endereco))), 0, 60))
        ->setCep(substr(str_replace('-', '', trim($dados->cep)), 0, 8))
        ->setCidade(substr(trim(iconv('UTF-8', 'UTF-8//IGNORE',$dados->cidade)), 0, 20))
        ->setBairro(substr(trim(iconv('UTF-8', 'UTF-8//IGNORE',$dados->bairro)), 0, 20))
        ->setUf(trim(iconv('UTF-8', 'UTF-8//IGNORE',$dados->estado)));
        //->setTelefone();
    $boletoRequest = new BoletoRequest();

    // $avalista = new AvalistaEntity();
    // $avalista->setTipoRegistro(TipoDocumento::CPF)
    //  ->setNumeroRegistro(71128590182)
    //  ->setNomeRegistro('Alfredão da ultrawave');

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
    $data = $bancoDoBrasil->register($boletoRequest);
    $bancoDoBrasil = validaStatus($data, $boletoRequest, $functions, $dados, $bancoDoBrasil);
}


function validaStatus($data, $boletoRequest, $functions, $dados, $bancoDoBrasil)
{
    if ($data['status']) {
        $functions->registraFatura($dados->numfatura);
        echo "{$dados->numfatura} - [SUCCESS] - Registrado com sucesso\n";
    } else {
        # code...
        if ($data['data']->getCode() == 401) {
            $bancoDoBrasil = new BancoDoBrasil([
                'clientId' => 'eyJpZCI6IjEwNTBlNDctYWM1NyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9',
                'clientSecret' => 'eyJpZCI6ImFiYWY3OTEtZjIzOS00ZDgzLThjNmMtNTU3ODM0NWFjNTZkZjlmYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjAwOTcxODIzMDU4fQ',
                'production' => true,
                'app_key' => '7091508b0affbe20136ae18190050e56b991a5b9',
                'type' => 2
            ]);
            $data = $bancoDoBrasil->register($boletoRequest);
            return validaStatus($data, $boletoRequest, $functions, $dados, $bancoDoBrasil);
        } else {
            $lines = explode("\n", $data['data']->getMessage());
            unset($lines[0]);
            $response = implode("\n", $lines);
            $response = json_decode($response);

            if (!isset($response->errors[0]->code)) {
                dd($data['data']->getMessage());
            }
            if ($response->errors[0]->code == '4432632.1') {
                $functions->registraFatura($dados->numfatura);
                echo "{$dados->numfatura} - {$response->errors[0]->message}\n";
            } else {
                echo "{$dados->numfatura} - [ERROR] -{$response->errors[0]->message}\n";
            }
        }
    }
    flush();
    return $bancoDoBrasil;
}