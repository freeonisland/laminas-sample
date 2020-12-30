<?php

namespace orch\V1\Rpc\Mag\FakeData;

class FakeOrders
{
    #csv
    public static function getOrderData(): string
    {
        $faker = \Faker\Factory::create();
       

        $id = mt_rand(100000, 200000);
        $return='';
        $fh = fopen('php://memory', 'w+');

        fputcsv($fh, [
            //"Facture N˚","Date de facturation","Commande N˚","Date de la Commande","Facture au nom","Statut","Montant"
            "Commande N˚","Date de la Commande","Facture au nom","Statut","Montant"
        ]);
        foreach (range(0,1) as $r)
            fputcsv($fh, [
                $id++,
                $faker->dateTimeBetween("-3 years", 'now')->format("Y-m-d"),
                $faker->name,
                array_rand(["accepted","validated","processing...","closed"]),
                $faker->regexify('[1-9]{0,2}[0-9]\.[1-9][0-9]€')
            ]);

        rewind($fh);
        $return .= stream_get_contents($fh);
        fclose($fh);

        return $return;
    }
}