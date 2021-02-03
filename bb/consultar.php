<?php
/**
 * Created by PhpStorm.
 * User: Ewerson
 * Date: 18/04/18
 * Time: 11:07
 */

require '../vendor/autoload.php';
use Ultrawave\CobrancaBB\BancoDoBrasil;
use Ultrawave\CobrancaBB\Helpers\Functions;

// if (!isset($_REQUEST['fatura_id']) || strlen(trim($_REQUEST['fatura_id'])) == 0) {
//     exit(json_encode([
//         'status' => false,
//         'message' => 'Informe o numero da fatura.',
//         'data' => []
//     ]));
// }
 // $fatura_id = $_REQUEST['fatura_id'];
 $fatura_id =  1612031;

$bancoDoBrasil = new BancoDoBrasil([
	'clientId' => 'eyJpZCI6IjEwNTBlNDctYWM1NyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9',
	'clientSecret' => 'eyJpZCI6ImFiYWY3OTEtZjIzOS00ZDgzLThjNmMtNTU3ODM0NWFjNTZkZjlmYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoxMTc0OSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjAwOTcxODIzMDU4fQ',
	'production' => true,
	'app_key' => '7091508b0affbe20136ae18190050e56b991a5b9',
	'type' => 3
]);

$functions = new Functions();
$dados = $functions->getDadosFatura($fatura_id);
$resp = $bancoDoBrasil->get('000' . $dados->nossonumero);
dd($resp);
echo json_encode($resp);
exit();
