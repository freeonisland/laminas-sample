<?php

namespace BlogTuto\Fixture;

class BlogFixture
{
    const TABLE = 'blog';

    public static function load(): void
    {
        $faker = \Faker\Factory::create();
        $sql = '';
        
        foreach (range(0,9) as $i) {
            $sql .= "INSERT INTO `".self::TABLE."` (title, content) " . "
                    VALUES ('".$faker->sentence(2)."', '".$faker->sentence(15)."');".PHP_EOL;
        }

        $db = new \PDO( sprintf('sqlite:%s/data/sqlite/%s.db', realpath(getcwd()), TableSchema::TABLE) );

        if (!$db->exec($sql)) {
            var_dump( $db->errorInfo()[2] );
        }

        $res = $db->query("SELECT * FROM blog");
        foreach($res->fetchAll(\PDO::FETCH_ASSOC) as $b) {
            
        }
    }
}