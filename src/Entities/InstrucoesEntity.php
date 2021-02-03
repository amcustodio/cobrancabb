<?php

namespace Ultrawave\CobrancaBB\Entities;

class InstrucoesEntity
{

    /**
     * @var array
     */
    public $instrucoes = [];

    /**
     * @var
     */
    public $demonstrativo;

    /**
     * @return array
     */
    public function getInstrucoes()
    {
        return $this->instrucoes;
    }

    /**
     * @param array $instrucoes
     * @return DadosComplementaresRequest
     */
    public function setInstrucoes(array $instrucoes)
    {
        $this->instrucoes = $instrucoes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDemonstrativo()
    {
        return $this->demonstrativo;
    }

    /**
     * @param mixed $demonstrativo
     * @return DadosComplementaresRequest
     */
    public function setDemonstrativo($demonstrativo)
    {
        $this->demonstrativo = $demonstrativo;
        return $this;
    }
}