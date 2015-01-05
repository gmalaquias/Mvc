<?php

/**
 * DAL
 * @author: Gabriel Malaquias
 * @date: 30/12/2014 16:44:52
 */

namespace Entities;

class Anotacao{
    /**
     * @PrimaryKey
     * @Name: AnotacaoId
     * @Type: int(11)
     */
    var $AnotacaoId;

    /**
     * @Name: Titulo
     * @Type: varchar(255)
     */
    var $Titulo;

    /**
     * @Name: Anotacao
     * @Type: longtext
     */
    var $Anotacao;

    /**
     * @Name: PessoaId
     * @Type: int(11)
     */
    var $PessoaId;

    /**
     * @Name: DataCadastro
     * @Type: timestamp
     */
    var $DataCadastro = CURRENT_TIMESTAMP;

    /**
     * @Name: DataAviso
     * @Type: date
     */
    var $DataAviso;

    /**
     * @Name: AvisoEnviado
     * @Type: tinyint(1)
     */
    var $AvisoEnviado = false;

    /**
     * @Name: Apagado
     * @Type: tinyint(1)
     */
    var $Apagado = false;

    /**
     * @Name: Pessoa
     * @Type: int(11)
     */
    var $Pessoa;

    /**
     * @Name: _Pessoa
     * @Fk: Pessoa
     * @Type: Pessoa
     */
    var $_Pessoa;

    /**
     * @Name: _Pessoa1
     * @Fk: PessoaId
     * @Type: Pessoa
     */
    var $_Pessoa1;

}
