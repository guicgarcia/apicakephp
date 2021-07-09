<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Firebase\JWT\JWT;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;



/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //$this->Auth->allow([]);
    }

    public function login()
    {
        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
            $data = [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' => time() + 3600 * 24 * 365
                ], Security::salt())
            ];

            $this->set([
                'data' => $data,
                '_serialize' => ['data']
            ]);
        } else {
            $this->response = $this->response->withStatus(400);
            $this->set([
                'data' => 'Usuário ou senha inválidos',
                '_serialize' => ['data']
            ]);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 40
        ];

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set([
            'data' => $users,
            '_serialize' => ['data']
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);

        $this->set([
            'data' => $user,
            '_serialize' => ['data']
        ]);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity($this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }

        $this->set([
            'data' => $user,
            'message' => $message,
            '_serialize' => ['data', 'message']
        ]);

        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }

        $this->set([
            'data' => $user,
            'message' => $message,
            '_serialize' => ['data', 'message']
        ]);

        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }

        $this->set([
            'data' => $user,
            'message' => $message,
            '_serialize' => ['data', 'message']
        ]);
    }

    public function logout()
    {
        $this->Flash->success(__('Deslogado com sucesso!'));

        $this->set([
            'message' => 'Deslogado com sucesso',
            '_serialize' => ['message']
        ]);

        $this->Auth->logout();
    }
}
