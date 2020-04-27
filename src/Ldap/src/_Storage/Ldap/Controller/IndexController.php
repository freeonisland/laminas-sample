<?php

namespace App\Storage\Ldap\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ldap")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return new Response(
            'bip2'
        );
    }
}
