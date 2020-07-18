<?php

namespace Album\Fixture;

class AlbumFixture
{
    const TABLE = 'album';

    public static function createTable(): void
    {
        //echo `sqlite /var/www/data/sqlite/album.db < /var/www/source/Album/src/Fixture/album.sql`;
        $db = new \PDO( sprintf('sqlite:%s/data/sqlite/album.db', realpath(getcwd())) );
        $db->exec(
            file_get_contents(__DIR__.'/album.sql')
        );
    }

    public static function load(): void
    {
        return;

        $faker = \Faker\Factory::create();
        $sql = '';
        foreach (range(0,9) as $i) {
            $sql .= "INSERT INTO `".self::TABLE."` (artist, title) " . "
                    VALUES ('".$faker->name."', '".$faker->sentence(2)."');".PHP_EOL;
        }

        $db = new \PDO( sprintf('sqlite:%s/data/sqlite/album.db', realpath(getcwd())) );
        var_dump( $db->exec(
            $sql
        ) );
    }
}