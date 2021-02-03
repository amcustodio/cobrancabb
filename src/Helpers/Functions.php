<?php
namespace Ultrawave\CobrancaBB\Helpers;
use PDO;

Class Functions {
    private $sb;

    public function __construct()
    {
        $this->db =  new PDO("pgsql:host=187.85.0.227 port=5432 dbname=ultrawave user=devuw password=devuw159753");
    }

    /**
     * Recupera os dados para registro da fatura
     * @param  int    $fatura_id
     * @return Object<Dados>
     */
    public function getDadosFatura(int $fatura_id)
    {
        $sql = "
        SELECT
            Remessa.nossonumero,
            Fatura.numfatura,
            Fatura.data_vencimento::date AS vencimento,
            Fatura.total AS valor,
            Cliente.nome,
            Cliente.fisica_juridica AS pessoa,
            Cliente.fk_cpfcnpj AS documento,
            Endereco.logradouro AS endereco,
            Endereco.bairro,
            Endereco.cidade,
            Endereco.cep,
            Endereco.estado,
            Banco.convenio,
            Banco.carteira,
            Banco.variacao
        FROM faturas Fatura
        LEFT JOIN cobranca.centro_custo Cobranca ON (Cobranca.id = Fatura.cobranca_id)
        LEFT JOIN sistema.enderecos Endereco ON (Endereco.id = Cobranca.endereco_id)
        LEFT JOIN clientes Cliente ON (Cliente.id_clientes = Cobranca.cliente_id)
        LEFT JOIN parametros_financeiros Parametros ON (1 = 1)
        LEFT JOIN cobbancos Banco ON (Banco.convenio = Parametros.convenio::text)
        LEFT JOIN cobremessas Remessa ON (Remessa.fatura = Fatura.numfatura)
        WHERE Fatura.numfatura = {$fatura_id}";

        return $this->db->query($sql)->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Seta o campo registrado para true na tabela faturas
     * @param  int    $fatura_id
     * @return bool
     */
    public function registraFatura(int $fatura_id)
    {
        $sql = "UPDATE faturas SET registrado = true WHERE numfatura = {$fatura_id}";
        return ($this->db->query($sql)) ? true : false;
    }

    public function getFaturas($emissao, $fim = 1)
    {
        $sql = "SELECT
                    Remessa.nossonumero,
                    Fatura.numfatura,
                    Fatura.data_vencimento::date AS vencimento,
                    Fatura.total AS valor,
                    Cliente.nome,
                    Cliente.fisica_juridica AS pessoa,
                    regexp_replace(Cliente.cpf_cnpj, '[./-]', '', 'g') AS documento,
                    Endereco.logradouro AS endereco,
                    Endereco.bairro,
                    Endereco.cidade,
                    Endereco.cep,
                    Endereco.estado,
                    Banco.convenio,
                    Banco.carteira,
                    Banco.variacao
                FROM faturas Fatura
                LEFT JOIN cobranca.centro_custo Cobranca ON (Cobranca.id = Fatura.cobranca_id)
                LEFT JOIN sistema.enderecos Endereco ON (Endereco.id = Cobranca.endereco_id)
                LEFT JOIN clientes Cliente ON (Cliente.id_clientes = Cobranca.cliente_id)
                LEFT JOIN parametros_financeiros Parametros ON (1 = 1)
                LEFT JOIN cobbancos Banco ON (Banco.convenio = Parametros.convenio::text)
                LEFT JOIN cobremessas Remessa ON (Remessa.fatura = Fatura.numfatura)
                WHERE Fatura.data_emissao::date >= '$emissao'
                AND fatura.registrado = false
                AND Remessa.numcarteira = '17'
                AND Fatura.tipo = 'T'
                AND RIGHT(Fatura.numfatura::text, 1) IN ($fim)
                AND Fatura.total >= 3
                AND Remessa.id_cobremessas IS NOT NULL
                ORDER BY Fatura.data_vencimento";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}