<?php

class Xpd_EmailForge_Model_Source_Fields
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'firstname',
                'label' => 'Nome'
            ),
            array(
                'value' => 'lastname',
                'label' => 'Sobrenome'
            ),
            array(
                'value' => 'gender',
                'label' => 'Sexo'
            ),
            array(
                'value' => 'telephone',
                'label' => 'Telefone'
            ),
            array(
                'value' => 'postcode',
                'label' => 'CEP'
            ),
            array(
                'value' => 'region',
                'label' => 'Estado'
            ),
        );
    }
}