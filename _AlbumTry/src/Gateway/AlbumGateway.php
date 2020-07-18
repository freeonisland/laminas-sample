<?php

namespace AlbumTry\Gateway;

use Laminas\Db\TableGateway\TableGatewayInterface;
use AlbumTry\Entity\AlbumEntity;

class AlbumGateway
{
    private $gateway;

    public function __construct(TableGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function fetchAll()
    {
        return $this->gateway->select();
    }

    public function fetching($id)
    {
        $c = $this->gateway->select(['id'=>$id]);
        if(!$c->current()) {
            throw new \InvalidArgumentException("Album $id n'existe pas");
        }
        return $c->current();
    }

    public function edit(AlbumEntity $album): void
    {
        $id = (int)$album->id;
        
        if (!$this->gateway->select($id)) {
            throw \InvalidArgumentException("L'album $id n'existe pas");
        }
        $data = [
            'title' => $album->title,
            'artist' => $album->artist
        ];

        $this->gateway->update($data, ['id'=>$id]);
    }   
}