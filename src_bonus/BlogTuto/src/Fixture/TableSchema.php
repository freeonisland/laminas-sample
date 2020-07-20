<?php

namespace BlogTuto\Fixture;

class TableSchema
{
    const TABLE = 'blogtuto';

    public static function createTable(): void
    {
        $db = new \PDO( sprintf('sqlite:%s/data/sqlite/%s.db', realpath(getcwd()), self::TABLE) );
        try {
            $db->exec(
                file_get_contents(__DIR__.'/../../schema/album.schema.sql')
            );
            $db->exec(
                file_get_contents(__DIR__.'/../../schema/blog.schema.sql')
            ); 
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
}