<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $components = array('RequestHandler');

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        
        $this->loadComponent('Flash');
        // $this->loadComponent('Auth', [
        //     'loginRedirect' =>[
        //         'controller'=>'Welcome',
        //         'action'=>'index'
        //     ],
        //     'logoutRedirect'=>[
        //         'controller'=>'Users',
        //         'action'=>'login'
        //     ],
        //     'authError' => false
        // ]);

        $this->loadComponent('Auth');

        $this->loadComponent('Auth', ['authenticate' => ['Form', 'ADmad/JwtAuth.Jwt']]);

        $this->response = $this->response->cors($this->request)
            ->allowOrigin(['*'])
            ->allowMethods(['*'])
            ->allowHeaders(['*'])
            ->build();

        if ($this->request->is('options')) {
            $this->Auth->allow();
        }

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function beforeRender(Event $event)
    {
        $prefix = null;
        if($this->request->getParam(['prefix']) !== null ){
            $prefix = $this->request->getParam(['prefix']);
        }

         if($prefix == 'admin')
        {
            if(($this->request->getParam(['action']) !== null ) AND (($this->request->getParam(['action']) == 'login') OR ($this->request->getParam(['action']) == 'cadastrar') OR ($this->request->getParam(['action']) == 'recuperarSenha') OR ($this->request->getParam(['action']) == 'atualizarSenha'))){
                $this->viewBuilder()->setLayout('login');
            }else{
                //$perfilUser = $this->Auth->user();
                $user = TableRegistry::get('Users');
                $perfilUser = $user->getUserDados(1); //$this->Auth->user('id')
                $this->set(compact('perfilUser'));

                $this->viewBuilder()->setLayout('admin');
            }
        }
    }
}
