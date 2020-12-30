<?php

namespace Application\Auth;

use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Permissions\Acl\ProprietaryInterface;

class ResourceBlog implements RoleInterface, ProprietaryInterface
{
    protected $id;
    protected $role = 'blog'; //default
    protected $author;

    public function __construct(string $id, string $role=null)
    {
        $this->id = $id;
        $this->role = $role;
    }

    public function getRoleId()
    {
        return $this->role;
    }

    public function getOwnerId()
    {
        return $this->id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}