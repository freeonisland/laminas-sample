<?php

namespace Application\Auth;

use Laminas\Permissions\Acl\Role\GenericRole;

class RoleBO extends GenericRole
{
    const ADMIN  = 'admin';
    const EDITOR = 'editor';
    const NEWS   = 'news';
    const DEMO   = 'demo';
}