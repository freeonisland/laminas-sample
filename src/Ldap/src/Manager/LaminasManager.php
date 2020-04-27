<?php declare(strict_types=1);

namespace Ldap\Manager;

use Laminas\Ldap\Dn;
use Laminas\Ldap\Ldap;
use Laminas\Ldap\Attribute;

class LaminasManager extends AbstractLdapManager implements LdapManagerInterface
{
    private $ldap;

    
    /*  
     * $options = [
        'host'              => 's0.foo.net',
        'username'          => 'CN=user1,DC=foo,DC=net',
        'password'          => 'pass1',
        'bindRequiresDn'    => true,
        'accountDomainName' => 'foo.net',
        'baseDn'            => 'OU=Sales,DC=foo,DC=net',
    ];
     */
    /*
__construct(array|Traversable $options = null) : void 	If no options are provided at instantiation, the connection parameters must be passed to the instance using setOptions(). The allowed options are specified in the options section.
getResource() : resource 	Returns the raw LDAP extension (ext/ldap) resource.
getLastErrorCode() : int 	Returns the LDAP error number of the last LDAP command.
getLastError(int &$errorCode = null, array &$errorMessages = null) : string 	Returns the LDAP error message of the last LDAP command. The optional $errorCode parameter is set to the LDAP error number when given. The optional $errorMessages array will be filled with the raw error messages when given. The various LDAP error retrieval functions can return different things, so they are all collected if $errorMessages is given.
setOptions(array|Traversable $options) : void 	Sets the LDAP connection and binding parameters. Allowed options are specified in the options section.
getOptions() : array 	Returns the current connection and binding parameters.
getBaseDn() : string 	Returns the base DN this LDAP connection is bound to.
getCanonicalAccountName(string $acctname, int $form) : string 	Returns the canonical account name of the given account name $acctname. $form specifies the format into which the account name is canonicalized. See Account Name Canonicalization for more details.
disconnect() : void 	Disconnects the instance from the LDAP server.
connect(string $host, int $port, bool $useSsl, bool $useStartTls, int $networkTimeout) : void 	Connects the instance to the given LDAP server. All parameters are optional and will be taken from the LDAP connection and binding parameters passed to the instance via the constructor or via setOptions() if null.
bind(string $username, string $password) : void 	Authenticates $username with $password on the LDAP server. If both parameters are omitted, the binding will be carried out with the credentials given in the connection and binding parameters. If no credentials are given in the connection and binding parameters, an anonymous bind will be performed. Note that this requires anonymous binds to be allowed on the LDAP server. An empty string, '', can be passed as $password together with a username if, and only if, allowEmptyPassword is set to true in the connection and binding parameters.
search(/ * ... * /) : Collection 	Searches the LDAP tree with the given $filter and the given search parameters; see below for full details.
    count(string|Filter\AbstractFilter $filter, string|Dn $basedn, int $scope) : int 	Counts the elements returned by the given search parameters. See search() for a detailed description of the method parameters.
    countChildren(string|Dn $dn) : int 	Counts the direct descendants (children) of the entry identified by the given $dn.
    exists(string|Dn $dn) : bool 	Checks whether the entry identified by the given $dn exists.
    searchEntries(/ * ... * /) : array 	Performs a search operation and returns the result as an PHP array. This is essentially the same method as search() except for the return type. See search() and searchEntries() below for more details.
    getEntry(string|Dn $dn, array $attributes, bool $throwOnNotFound) : array 	Retrieves the LDAP entry identified by $dn with the attributes specified in $attributes. if $attributes is omitted, all attributes ([]) are included in the result. $throwOnNotFound is false by default, so the method will return null if the specified entry cannot be found. If set to true, a Laminas\Ldap\Exception\LdapException will be thrown instead.
    prepareLdapEntryArray(array &$entry) : void 	Prepare an array for the use in LDAP modification operations. This method does not need to be called by the end-user as it's implicitly called on every data modification method.
    add(string|Dn $dn, array $entry) : void 	Adds the entry identified by $dn with its attributes $entry to the LDAP tree. Throws a Laminas\Ldap\Exception\LdapException if the entry could not be added.
    update(string|Dn $dn, array $entry) : void 	Updates the entry identified by $dn with its attributes $entry to the LDAP tree. Throws a Laminas\Ldap\Exception\LdapException if the entry could not be modified.
    save(string|Dn $dn, array $entry) : void 	Saves the entry identified by $dn with its attributes $entry to the LDAP tree. Throws a Laminas\Ldap\Exception\LdapException if the entry could not be saved. This method decides by querying the LDAP tree if the entry will be added or updated.
    delete(string|Dn $dn, boolean $recursively) : void 	Deletes the entry identified by $dn from the LDAP tree. Throws a Laminas\Ldap\Exception\LdapException if the entry could not be deleted. $recursively is false by default. If set to true the deletion will be carried out recursively and will effectively delete a complete subtree. Deletion will fail if $recursively is false and the entry $dn is not a leaf entry.
    moveToSubtree(string|Dn $from, string|Dn $to, bool $recursively, bool $alwaysEmulate) : void 	Moves the entry identified by $from to a location below $to keeping its RDN unchanged. $recursively specifies if the operation will be carried out recursively (false by default) so that the entry $from and all its descendants will be moved. Moving will fail if $recursively is false and the entry $from is not a leaf entry. $alwaysEmulate controls whether the ext/ldap function ldap_rename() should be used if available. This can only work for leaf entries and for servers and for ext/ldap supporting this function. Set to true to always use an emulated rename operation. All move-operations are carried out by copying and then deleting the corresponding entries in the LDAP tree. These operations are not atomic so that failures during the operation will result in an inconsistent state on the LDAP server. The same is true for all recursive operations. They also are by no means atomic. Please keep this in mind.
    move(string|Dn $from, string|Dn $to, bool $recursively, bool $alwaysEmulate) : void 	This is an alias for rename().
    rename(string|Dn $from, string|Dn $to, bool $recursively, bool $alwaysEmulate) : void 	Renames the entry identified by $from to $to. $recursively specifies if the operation will be carried out recursively (false by default) so that the entry $from and all its descendants will be moved. Moving will fail if $recursively is false and the entry $from is not a leaf entry. $alwaysEmulate controls whether the ext/ldap function ldap_rename() should be used if available. This can only work for leaf entries and for servers and for ext/ldap supporting this function. Set to TRUE to always use an emulated rename operation.
    copyToSubtree(string|Dn $from, string|Dn $to, bool $recursively) : void 	Copies the entry identified by $from to a location below $to keeping its RDN unchanged. $recursively specifies if the operation will be carried out recursively (false by default) so that the entry $from and all its descendants will be copied. Copying will fail if $recursively is false and the entry $from is not a leaf entry.
    copy(string|Dn $from, string|Dn $to, bool $recursively) : void 	Copies the entry identified by $from to $to. $recursively specifies if the operation will be carried out recursively (false by default) so that the entry $from and all its descendants will be copied. Copying will fail if $recursively is false and the entry $from is not a leaf entry.
    getNode(string|Dn $dn) : Node 	Returns the entry $dn wrapped in a Laminas\Ldap\Node.
    getBaseNode() : Node 	Returns the entry for the base DN $baseDn wrapped in a Laminas\Ldap\Node.
    getRootDse() : Node\RootDse 	Returns the RootDSE for the current server.
    getSchema() : Node\Schema
    */
    public function connect(): bool
    {
        $options = [
            'host'              => $this->ldapServer,
            'username'          => $this->ldapDn,
            'password'          => $this->ldapPass,
            'bindRequiresDn'    => true,
            'accountDomainName' => 'my-company.com',
            'baseDn'            => 'cn=Sales,dc=my-company,dc=com',
            'networkTimeout'    => 30
        ];
        
        $this->ldap = new Ldap($options);
        //$acctname = $ldap->getCanonicalAccountName('abaker', Ldap::ACCTNAME_FORM_DN);
        //echo "$acctname\n";
        try {
            if ($this->ldap) {
                return true;
            } else {
                echo "Can't connect to LDAP Laminas";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
        return false;
    }

    function getLdap(): Ldap
    {
        return $this->ldap;
    }

    public function getSchemas(): array
    {
        $s = $this->search( 
            'objectClass=subSchema',
            'cn=Subschema',
            \Laminas\Ldap\Ldap::SEARCH_SCOPE_BASE, 
            ['objectclasses']
        );
        $s = $s ? $s[0]['objectclasses'] : [];
        $r=[];
        array_walk($s,function($v,$k) use (&$r) {
            preg_match("/NAME\s'([\w-]*)'/",$v,$name);
            $r[$name[1]]['description'] = $v;
            
            $v = explode('MAY',$v);
            $may = count($v)<2 ? null : explode('$',str_replace(['(',')',' '],'',$v[1]));
            if ($may) sort($may);

            $v = explode('MUST',$v[0]);
            $must = count($v)<2 ? null : explode('$',str_replace(['(',')',' '],'',$v[1]));
            if ($must) sort($must);

            $r[$name[1]]['must'] = $must;
            $r[$name[1]]['may'] = $may;
        });

        ksort($r);
        
        return $r;
    }

    /*
     * Search
     * 
     * search(
    string|Filter\AbstractFilter $filter,
    string|Dn $basedn,
    int $scope,
    array $attributes,
    string $sort,
    string $collectionClass,
    int $sizelimit,
    int $timelimit
) : Collection
     */
    public function search($filter, $basedn=null, $scope=Ldap::SEARCH_SCOPE_SUB, $return_attr=['*'])
    {
        $basedn = $basedn ?? $this->basedn;
        $s=$this->ldap->searchEntries($filter, $basedn, $scope, $return_attr);
        //s($this->ldap->getEntry());
        return $s;
        //s(get_class_methods($this->ldap));
    }

    public function add(string $objectClass, array $data)
    {
        /**
         * add
         */
        $data['objectClass'] = $objectClass;

        try {
            $dn = "cn={$data['cn']},".$this->basedn;
            $this->ldap->add($dn, $data);
            echo 'Data inserted...<br/>';
        } catch(\Exception $e) { echo 'EXCEPTION:'.$e->getMessage().'<br/>'; } 
    }

    public function update(string $objectClass, string $uid, array $data)
    {
        /**
         * add
         */
        $data['objectClass'] = $objectClass;

        try {
            $dn = "cn={$uid},".$this->basedn;
            $this->ldap->update($dn, $data);
            echo 'Data updated...<br/>';
        } catch(\Exception $e) { echo 'EXCEPTION:'.$e->getMessage().'<br/>'; } 
    }

    public function delete(string $uid)
    {
        try {
            $dn = "cn={$uid},".$this->basedn;
            $this->ldap->delete($dn);
            echo 'Data deleted...<br/>';
        } catch(\Exception $e) { echo 'EXCEPTION:'.$e->getMessage().'<br/>'; } 
    }

    public function get($uid)
    {
        $res=$this->search('cn='.$uid);
        return $res;
    }

}