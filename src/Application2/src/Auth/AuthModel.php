<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Auth;

use Laminas\Permissions\Acl;
use Laminas\Permissions\Acl\Assertion\ExpressionAssertion;


use Application\Auth\ResourceUser;
use Application\Auth\ResourceBlog;
use Application\Auth\RoleBO;


class AuthModel
{
    function getAcl()
    {
        $res56 = new ResourceUser(56);
        $resJ  = new ResourceUser('Jess');
        $resA  = new ResourceUser('alpha');

        $resBlog  = new ResourceBlog('one', 'specific_blog');
        $resBlog->setAuthor($res56);

        $admin  = new RoleBO(RoleBO::ADMIN);
        $editor = new RoleBO(RoleBO::EDITOR);
        $news   = new RoleBO(RoleBO::NEWS);
        $demo   = new RoleBO(RoleBO::DEMO);

        /**
         * ACL
         */
        $acl = new Acl\Acl();
        $acl->addRole($demo);
        $acl->addRole($news, $demo); //privileges of Demo, and News
        $acl->addRole($editor, $news); //privileges of News, and Editor
        $acl->addRole($admin, [$editor, $news]); //HIGH, [parents: lesser to higher]

        // permission
        $acl->allow($demo, null, 'viewing'); //apply to all resoources
        $acl->allow($news, null, ['send_email']); //inherit "view"
        $acl->allow($editor, null, ['pub','edit','remove']);
        
        // rights for resources
        $acl->addResource($res56);
        $acl->allow(RoleBO::NEWS, $res56->getResourceId()); //allow demo too
        $acl->deny(RoleBO::EDITOR, $res56->getResourceId());
        $acl->deny(RoleBO::ADMIN, $res56->getResourceId());

        // check
        echo 'admin-view?:' . ($acl->isAllowed(RoleBO::ADMIN, null, 'viewing') ? 'ok' : 'nop');
        echo ' 56-email?:' . ($acl->isAllowed($news, $res56->getResourceId(), 'send_email') ? 'ok' : 'nop');

        // Assertions
        $isEditedDescription = ExpressionAssertion::fromArray([
            'left'     => [ExpressionAssertion::OPERAND_CONTEXT_PROPERTY => 'resource.description'],
            'operator' => 'regex',
            'right'    => '/marque/i',
        ]);
        $isEditedDescription->assert($acl, null, $res56) == true;

        return $acl;
    }
}