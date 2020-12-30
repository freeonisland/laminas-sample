<?php

namespace Application\Model\Fixture;

use Application\Table\ModelTable;
use Application\Model\Model;

class ModelFixture extends AbstractFixture
{
   protected $rows = 10;

    protected function generate()
    {
        $faker = \Faker\Factory::create();

        $model = new Model;
        $model->id_model = (string)substr(uniqId(),9);
        $model->country = $faker->country();
        $model->price = $faker->randomFloat(2, 0, rand(99,999));
        $model->json = $this->json();
        $model->date = $this->date();

        $this->insertFixture($model);
    }

    protected function json()
    {
        $faker = \Faker\Factory::create();

        $data = [];
        foreach (range(0, rand(5,10)) as $_) {
            $data[] = $faker->word();
        }
        return json_encode(join(',',$data));
    }

    protected function date()
    {
        // @link https://www.php.net/manual/fr/dateinterval.construct.php
        return (new \DateTime())->add(new \DateInterval("PT".rand(0,1e6)."S"))->format("Y/m/d H:i:s");
    }
}