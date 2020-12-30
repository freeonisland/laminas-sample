<?php

namespace Application\Auth;

use Laminas\Permissions\Acl\Resource\GenericResource;

class ResourceUser extends GenericResource
{
    public $description = 'Utilisateur de la marque';
}