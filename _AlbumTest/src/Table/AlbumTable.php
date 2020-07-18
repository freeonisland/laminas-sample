<?php

namespace Album\Table;

use Laminas\Db\TableGateway\TableGateway;
use Album\Entity\Album;

class AlbumTable extends TableGateway
{
    public function fetchAll()
    {
        return $this->select();
    }

    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int) $album->id;

        if ($id === 0) {
            $this->insert($data);
            return;
        }

        try {
            $this->getAlbum($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

       $this->update($data, ['id' => $id]);
    }

    public function deleteAlbum($id)
    {
        $this->delete(['id' => (int) $id]);
    }
}