<?php

namespace Soap\Stream;

/**
 * file_get_contents(var://alpha) => $alpha
 */
class VarStream implements \Interfaces\StreamWrapperInterface
{
    /**
     * Variable
     */
    private $data;

    /**
     * opions
     */
    private $options; //change behavior with options

    /**
     * Met fin au stream when called with feof()
     */
    public function stream_eof(): bool
    {
        return true;
    }

    /**
     * FIRST
     * Call with fopen by fopen, fsockopen, etc...
     */
    public function stream_open(string $path, string $mode='rb', int $options=0, ?string &$opened_path=''): bool
    {
        $varname = parse_url($path)['host'];
        return true;
    }

    /**
     * Used for Rewing()
     */
    public function seek()
    {

    }

    /**
     * Readed with fread....
     */
    public function stream_read(int $count)
    {
        return $this->data;
    }

    public function stream_stat(): array
    {
        return [];
    }

    /**
     * int: addition
     * string: append
     * 
     * @return int nombre de donnée écrites
     */
    public function stream_write(string $data): int
    {
        $type = 'string';
        if(ctype_digit($data)){
            $type = 'int';
            $data = (int)$data;
        } 
        
        switch($type) { 
            case 'int': $this->data = null===$this->data ? $data : $this->data + $data;
                return strlen($data);
            case 'string': $this->data = null===$this->data ? $data : $this->data . $data;
                return strlen($data);
            default: 
                return 0;
        }
    }

    //function stream_metadata($path, $option, $var) 
}


/*
     streamWrapper::__construct — Construit un nouveau gestionnaire de flux
    streamWrapper::__destruct — Détruit un gestionnaire de flux existant
    streamWrapper::dir_closedir — Ferme une ressource de dossier
    streamWrapper::dir_opendir — Ouvre un dossier en lecture
    streamWrapper::dir_readdir — Lit un fichier dans un dossier
    streamWrapper::dir_rewinddir — Remet au début une ressource de dossier
    streamWrapper::mkdir — Crée un dossier
    streamWrapper::rename — Renomme un fichier ou un dossier
    streamWrapper::rmdir — Supprime un dossier
    streamWrapper::stream_cast — Lit la ressource sous-jacente de flux
    streamWrapper::stream_close — Ferme une ressource de flux
    streamWrapper::stream_eof — Tests for end-of-file on a file pointer
    streamWrapper::stream_flush — Expédie le contenu
    streamWrapper::stream_lock — Verrouillage logique de fichiers
    streamWrapper::stream_metadata — Change les metadata du flux
    streamWrapper::stream_open — Opens file or URL
    streamWrapper::stream_read — Lit dans le flux
    streamWrapper::stream_seek — Place le pointeur de flux à une position
    streamWrapper::stream_set_option — Change les options du flux
    streamWrapper::stream_stat — Lit les informations sur une ressource de fichier
    streamWrapper::stream_tell — Lit la position courante dans un flux
    streamWrapper::stream_truncate — Tronque un flux
    streamWrapper::stream_write — Écrit dans un flux
    streamWrapper::unlink — Efface un fichier
    streamWrapper::url_stat — Lit les informations sur un fichier 
 */