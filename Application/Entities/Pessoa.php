<?php

/**
 * DAL
 * @author: Gabriel Malaquias
 * @date: 19/01/2015 14:10:56
 */

namespace Entities;

class Pessoa{
    /**
     * @PrimaryKey
     * @Name: PessoaId
     * @Type: int(11)
     */
    var $PessoaId = 0;

    /**
     * @DisplayName: Nome Completo
     * @Name: Nome
     * @Type: varchar(60)
     * @Required
     * @Length: 5,100
     */
    var $Nome;

    /**
     * @Name: Email
     * @Type: varchar(60)
     * @Email
     * @Required
     */
    var $Email;

    /**
     * @Name: Foto
     * @Type: varchar(255)
     */
    var $Foto;

    /**
     * @Name: Telefone
     * @Type: varchar(25)
     */
    var $Telefone;

    /**
     * @Name: Celular
     * @Type: varchar(25)
     */
    var $Celular;

    /**
     * @Name: Comercial
     * @Type: varchar(25)
     */
    var $Comercial;

    /**
     * @Name: Fax
     * @Type: varchar(25)
     */
    var $Fax;

    /**
     * @Name: DataCriacao
     * @Type: timestamp
     */
    var $DataCriacao = CURRENT_TIMESTAMP;

    /**
     * @Name: UltimaModificacao
     * @Type: datetime
     */
    var $UltimaModificacao;

    /**
     * @Name: TipoPessoaFisica
     * @Type: tinyint(1)
     */
    var $TipoPessoaFisica = false;

    /**
     * @Name: Apagado
     * @Type: tinyint(1)
     */
    var $Apagado = false;


    /**
     * @NotMapped
     * @Name: _Pessoa
     * @Fk: PessoaId
     * @Type: Anotacao
     * @Virtual
     */
    var $_Anotacoes;
}
