<?php

namespace Emtudo\Support\Helpers;

class States
{
    /**
     * @var array
     */
    protected static $cities = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];

    /**
     * @return array
     */
    public static function getUFCodes()
    {
        return array_keys(self::get());
    }

    /**
     * @return array
     */
    public static function get()
    {
        return self::$cities;
    }

    /**
     * @return array
     */
    public static function getNames()
    {
        return array_values(self::get());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getCollection()
    {
        return collect(self::get());
    }
}
