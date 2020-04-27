<?php

namespace App\Storage\Ldap\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Ldap\Entity\User;
use Ldap\Entity\LaminasRepository;

class UserController extends AbstractController
{
    /**
     * 
     */
    public function listAction()
    {
        $lm = $this->getModule('LaminasManager');
        $schemas = $this->schemas();
        $res = $lm->search('objectClass=person');

        return [
            'users' => $res??[]
        ];
    }

    /**
     * 
     */
    public function createAction()
    {   
        $lm = $this->getModule('LaminasManager');
        $schemas = $lm->getSchemas();
        
        if ($this->post && 'yes' !== $this->post['onlychange']) {
            // Create data ...
            $lm->add('person', [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        $comm = 'ssh -o StrictHostKeyChecking=no root@ldap-server "ldapcompare" 2>&1';
        $exec=exec($comm, $out);
        //s($out);
        /*$exec=shell_exec($comm);
        s($exec);
        s($out);
        $exec=system($comm);
        s($exec);
        $exec=`ssh`;
        s($exec);
        $exec=passthru($comm);
        s($exec);

        exec("ping -c 1 yhoo.dsd 2>&1", $output, $return_var);
        s($output);
        s($return_var);*/

        return [
            'user' => [
                'cn'=>[''],
                'sn'=>['']
            ],
            'schemas' => $schemas,
            'post' => $this->post
        ]; 
    }

    public function updateAction(string $userId)
    {
        $lm=$this->getModule('LaminasManager');

        if($this->post) {
            // Update data ...
            $lm->update('person', $this->post['uid'], [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        $s="(&(objectClass=person)(cn={$userId}))";
        $user=$lm->search($s);

        return [
            'user' => $user[0]
        ]; 
    }

    /**
     * 
     */
    public function viewAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->search("(&(cn={$userId})(objectClass=person))");

        return [
            'user' => $user?$user[0]:null
        ]; 
    }

    /**
     * 
     */
    public function deleteAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->get($userId);
             
        
        if(count($this->post)) {
            // Delete data ...
            s($this->post);
            if('yes'===$this->post['confirm']) {
                $lm->delete($userId);
                \Flight::redirect('/ldap/user/list');
                die();
            }
        }

        return [
            'user' => $user[0]
        ]; 
    }
}
