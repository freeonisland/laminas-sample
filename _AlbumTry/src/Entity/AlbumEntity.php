<?php

namespace AlbumTry\Entity;

use Laminas\InputFilter\{InputFilter, InputFilterInterface, InputFilterAwareInterface};

class AlbumEntity 
{
    private $id, $title, $artist;

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function exchangeArray($data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
    }

    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'artist' => $this->artist,
            'title'  => $this->title,
        ];
    }

}