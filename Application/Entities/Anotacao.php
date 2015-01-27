<?php

/**
 * DAL
 * @author: Gabriel Malaquias
 * @date: 19/01/2015 14:10:55
 */

namespace Application\Entities;

class Anotacao{
    /**
     * @PrimaryKey
     * @Name: AnotacaoId
     * @Type: int(11)
     */
    var $AnotacaoId = 0;

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
    var $PessoaId = 0;

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
    var $Pessoa = 0;

    /**
     * @NotMapped
     * @Name: _Pessoa
     * @Fk: PessoaId
     * @Type: Pessoa
     */
    var $_Pessoa;

    /**
     * @NotMapped
     * @Name: _Pessoa1
     * @Fk: Pessoa
     * @Type: Pessoa
     */
    var $_Pessoa1;


}
