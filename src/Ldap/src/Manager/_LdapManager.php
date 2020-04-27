<?php

declare(strict_types=1);

namespace Ldap\Manager;

class LdapManager 
{
    function connect() 
    {
        // Eléments d'authentification LDAP
        $ldaprdn  = 'cn=admin,dc=my-company,dc=com';     // DN ou RDN LDAP
        $ldappass = 'JonSn0w';  // Mot de passe associé

        // Connexion au serveur LDAP
        $ldapconn = ldap_connect("ldap://ldap-server")
            or die("Impossible de se connecter au serveur LDAP.");

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($ldapconn) {
            // Connexion au serveur LDAP
            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
            s($ldapbind);

            // Vérification de l'authentification
            if ($ldapbind) {
                //echo "réussie...";
            } else {
                echo "échouée...";
            }

        } else {
            echo "Bind impossible...";
        }
    }
}