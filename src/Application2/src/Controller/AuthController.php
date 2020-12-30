<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter;
use Laminas\Authentication\Storage\Session as SessionStorage;

class AuthController extends AbstractActionController
{
    
    public function aclAction($params=null)
    {
        $model = new \Application\Auth\AuthModel;
        $acl = $model->getAcl();

        // view 
        $view = new ViewModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }

    /**
     * Ressource one
     */
    public function authenticateAction()
    {
        // Instantiate the authentication service:
        $auth = new AuthenticationService();

        // Instantiate the authentication adapter:
        $authAdapter = new Adapter\Callback(function($identity, $credential) {
            if('p@ss' == $credential) 
                return 'My identity'; 
            return false;
        });
        $authAdapter->setIdentity('anyway-user-id');

        $authAdapter->setCredential('wrong-password');
        $auth->authenticate($authAdapter) === false;


        $authAdapter->setCredential('p@ss');
        // Attempt authentication, saving the result:
        $result = $auth->authenticate($authAdapter);

        if (! $result->isValid()) {
            echo '<b>Errors</b>: <br/>';
            // Authentication failed; print the reasons why:
            foreach ($result->getMessages() as $message) {
                echo "$message\n";
            }
        } else {
            // Authentication succeeded; the identity ($username) is stored
            // in the session:
            echo 'Identity: ' . $result->getIdentity();
        }

        // view 
        $view = new ViewModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }

    /**
     * Ressource one
     */
    public function digestAction()
    {
        // Instantiate the authentication service:
        $auth = new AuthenticationService();
        // Use 'someNamespace' instead of 'Laminas_Auth'
        $auth->setStorage(new SessionStorage('Credentials_Namespace'));

        /**
         * Generate
         */
        $user = 'userword';
        $pass = 'd!gestp@ass';
        $realm = "Laminas realm";
        $file = __DIR__ . '/../Auth/digest';

        // generate authentication file (must only be done once!)
        file_put_contents($file, sprintf("%s:%s:%s", $user, $realm, md5("$user:$realm:$pass")));

        /**
         * From input
         */
        $fromInputPass = 'wrongPassword';
        // get adapter
        $digest = new Adapter\Digest($file, $realm, $user, $fromInputPass);
        $result = $digest->authenticate() === false;

        $fromInputPass = 'd!gestp@ass'; //good one
        // get adapter
        $digest = new Adapter\Digest($file, $realm, $user, $fromInputPass);
        $result = $auth->authenticate($digest);

        

        if (! $result->isValid()) {
            echo '<b>Errors</b>: <br/>';
            // Authentication failed; print the reasons why:
            foreach ($result->getMessages() as $message) {
                echo "$message\n";
            }
        } else {
            // Authentication succeeded; the identity ($username) is stored
            // in the session:
            $res = ('Identity SUCCESS: ' . $result->getIdentity()['realm']);
        }

        // view 
        $view = new ViewModel([
            'auth' => $res
        ]);
       
        return $view;
    }


}
