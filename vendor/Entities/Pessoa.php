<?php

/**
 * DAL
 * @author: Gabriel Malaquias
 * @date: 30/12/2014 16:10:01
 */

namespace Entities;

class Pessoa{
    /**
     * @PrimaryKey
     * @Name: PessoaId
     * @Type: int(11)
     */
    var $PessoaId;

    /**
     * @Name: Nome
     * @Type: varchar(60)
     */
    var $Nome;

    /**
     * @Name: Email
     * @Type: varchar(60)
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

}
