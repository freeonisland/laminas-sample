<?php

namespace Application\Model\Fixture;

use Application\Model\AccessLogTable;

class AccessLogFixture extends AbstractFixture
{
    private $rows = 10;
    private $data = [
        'user' => 'name'
    ];

    function insertData(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(0, $this->rows) as $r) {
            $this->table->insert(['user' => $faker->name]);
        }
    }
}