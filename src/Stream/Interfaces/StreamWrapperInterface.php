<?php

namespace Interfaces;

/**
 * file_get_contents(var://alpha) => $alpha
 */
interface StreamWrapperInterface
{
    public function stream_eof(): bool;
    public function stream_open(string $path, string $mode='rb', int $options=0, ?string &$opened_path=''): bool;
    public function stream_read(int $count);
    public function stream_stat(): array;
    public function stream_write(string $data): int;
}

/*
 * /* Propriétés 
public resource $context ;

/* Méthodes 
__construct ( void )
__destruct ( void )
public dir_closedir ( void ) : bool
public dir_opendir ( string $path , int $options ) : bool
public dir_readdir ( void ) : string
public dir_rewinddir ( void ) : bool
public mkdir ( string $path , int $mode , int $options ) : bool
public rename ( string $path_from , string $path_to ) : bool
public rmdir ( string $path , int $options ) : bool
public stream_cast ( int $cast_as ) : resource
public stream_close ( void ) : void
public stream_eof ( void ) : bool
public stream_flush ( void ) : bool
public stream_lock ( int $operation ) : bool
public stream_metadata ( string $path , int $option , mixed $value ) : bool
public stream_open ( string $path , string $mode , int $options , string &$opened_path ) : bool
public stream_read ( int $count ) : string
public stream_seek ( int $offset , int $whence = SEEK_SET ) : bool
public stream_set_option ( int $option , int $arg1 , int $arg2 ) : bool
public stream_stat ( void ) : array
public stream_tell ( void ) : int
public stream_truncate ( int $new_size ) : bool
public stream_write ( string $data ) : int
public unlink ( string $path ) : bool
public url_stat ( string $path , int $flags ) : array
 */

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