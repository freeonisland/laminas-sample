<?php

namespace BlogTuto\Fixture;

class AlbumFixture
{
    const TABLE = 'album';

    public static function load(): void
    {
        $faker = \Faker\Factory::create();
        $sql = '';
        
        foreach (range(0,9) as $i) {
            $sql .= "INSERT INTO `".self::TABLE."` (artist, title) " . "
                    VALUES ('".$faker->name."', '".$faker->sentence(2)."');".PHP_EOL;
        }

        //$db = new \PDO( sprintf('sqlite:%s/data/sqlite/%s.db', realpath(getcwd()), TableSchema::TABLE) );

        try {
            $db->exec($sql);
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
}