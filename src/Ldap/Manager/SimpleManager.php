<?php declare(strict_types=1);

namespace App\Storage\Ldap\Manager;

class SimpleManager// extends AbstractLdapManager implements LdapManagerInterface
{

}
   /* public function connect(): bool
    {
        //$ldap_conn = ldap_connect('ldap://' . $this->ldapServer);
        return false;

        try {
            if ($d=ldap_bind_ext($ldap_conn, $this->ldapDn, $this->ldapPass, [['oid' => LDAP_CONTROL_PASSWORDPOLICYREQUEST]] )) {
                //echo 'Simple-LDAP connected.';
                
                return true;
            } else {
                echo "Can't connect to Simple-LDAP";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
        return false;
    }

}*/



/*
@todo

    $ldapconn = ldap_connect("ldap://ldap-server")
    or die("Impossible de se connecter au serveur LDAP.");
    $ld=$ldapconn;
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    if ($ldapconn) {

        // Connexion au serveur LDAP
        $ldapbind = ldap_bind($ldapconn, 'cn=admin,dc=my-company,dc=com', 'JonSn0w');
        // Vérification de l'authentification
        if ($ldapbind) {
            echo "Connexion LDAP réussie...";
        } else {
            echo "Connexion LDAP échouée...";
        }

        
        
GET ALL SUBSCHEMAS
*  $search = ldap_read($ld, "", "objectclass=*", array('*', 'subschemasubentry'));
$entries = ldap_get_entries($ld, $search);
$schemadn = $entries[0]["subschemasubentry"][0];

print "Searching ". $schemadn . "<br/>";

// Read all objectclass, attributetype from subschema
$schsearch = ldap_read($ld, $schemadn, "objectClass=subSchema", array('objectclasses', 'attributetypes'));
$schentries = ldap_get_entries($ld, $schsearch);

$count = $schentries[0]["attributetypes"]["count"];

print "Printing all attribute types <br/>";
for ($i=0; $i<$count; $i++)
 print $schentries[0]["attributetypes"][$i] . "<br/>";


$count = $schentries[0]["objectclasses"]["count"];

print "Printing all objectclasses <br/>";
for ($i=0; $i<$count; $i++)
 print $schentries[0]["objectclasses"][$i] . "<br/>";

*/

//$schsearch = ldap_read($ld, 'cn=Subschema', "objectClass=subSchema", ['*']); //array('objectclasses', 'attributetypes'));
        //$schentries = ldap_get_entries($ld, $schsearch);
//s($schentries);
        

        /*
        //s($ldapbind);
        $search = ldap_read($ldapconn, "", "objectclass=*", array('*', 'subschemasubentry'));
        
        $entries = ldap_get_entries($ldapconn, $search);
        s($entries);
        $schemadn = $entries[0]["subschemasubentry"][0];

        $entries = ldap_get_entries($ld, $search);
$schemadn = $entries[0]["subschemasubentry"][0];

print "Searching ". $schemadn . "<br/>";

// Read all objectclass, attributetype from subschema
$schsearch = ldap_read($ld, $schemadn, "objectClass=subSchema", array('objectclasses', 'attributetypes'));
$schentries = ldap_get_entries($ld, $schsearch);
s($schentries);*/

//        $ldap = $lm->getLdap();
//      $s = $lm->search('objectClass=*');


    //s($s);
    /*$search = ldap_read($ld, "", "objectclass=*", array('*', 'subschemasubentry'));
    $entries = ldap_get_entries($ld, $search);
    $schemadn = $entries[0]["subschemasubentry"][0];*/