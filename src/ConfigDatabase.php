<?php

namespace Kaliel\Comarquage;

use Kirby\Database\Database;

class ConfigDatabase
{

    private static ConfigDatabase $_instance;

    private Database $database;


    public function __construct()
    {
        $this->database = new Database([
            'type' => 'sqlite',
            'target' => kirby()->roots()->cache() . 'comarquage.sqlite'
        ]);
    }

    /**
     * @return ConfigDatabase
     */
    public static function getInstance(): ConfigDatabase
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ConfigDatabase();
        }
        return self::$_instance;
    }

}
