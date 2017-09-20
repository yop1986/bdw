<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry; 

/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 *
 * @method \App\Model\Entity\Usuario[] paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['add']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $usuarios = $this->paginate($this->Usuarios);

        $this->set(compact('usuarios'));
        $this->set('_serialize', ['usuarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Cuentas']
        ]);

        $this->set('usuario', $usuario);
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            $usuario['creado'] = Time::Now();
            $usuario['activo'] = 0;
            $usuario['grupo'] = 'Cliente';


            $this->Cuentas = TableRegistry::get('cuentas');
            $infoCuenta = (
                $this->Cuentas->find()
                    ->select(['id'])
                    ->where(['cuentas.cuenta' => $usuario['cuenta']])
                )->first();

            if (!is_null($infoCuenta)) //existe la cuenta
            {
                $this->CuentasUsuarios = TableRegistry::get('cuentas_usuarios');
                $infoAsoc = (
                    $this->CuentasUsuarios->find()
                        ->select(['id'])
                        ->where(['cuentas_usuarios.cuenta_id' => $infoCuenta->id])
                    )->first();

                if (is_null($infoAsoc)) //no esta asociada la cuenta a ningun usuario
                {
                    unset($usuario['cuenta']);

                    $data['usuario_id'] = ($this->Usuarios->save($usuario))->id;
                    $data['cuenta_id'] = $infoCuenta->id;

                    $infoAsoc = $this->CuentasUsuarios->newEntity();
                    $infoAsoc = $this->CuentasUsuarios->patchEntity($infoAsoc, $data);

                    $this->CuentasUsuarios->save($infoAsoc);

                    $this->Flash->success(__('El usuario fue guardado, por favor confirme desde su correo.'));

                    return $this->redirect(['action' => 'login']);
                }
                else
                {
                    $this->Flash->error(__('¡La Cuenta ya está asociada a un cliente!.'));
                }
            }
            else
            {
                $this->Flash->error(__('¡La Cuenta no existe!.'));
            }

        }
        $this->set(compact('usuario'));
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            $usuario['modificado'] = Time::Now();
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('The usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
        }
        $this->set(compact('usuario'));
        $this->set('_serialize', ['usuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('The usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The usuario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post'))
        {
            $usuario = $this->Auth->identify();
            if ($usuario)
            {
                $this->Auth->setUser($usuario);

                $usrLogueado = $this->request->session()->read('Auth.User');

                if($usrLogueado['grupo'] == 'Administrador'){
                    return $this->redirect(['controller' => 'Usuarios', 'action' => 'index']);
                }
                
                return $this->redirect($this->Auth->redirectUrl());
            } 
            else
            {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function changeState($id = null)
    {
        $usuario = $this->Usuarios->get($id);

        if ($usuario->grupo !== 'Administrador') {
            $usuario = $this->Usuarios->patchEntity($usuario, [$usuario['activo'] = !$usuario['activo']]);

            if ($this->Usuarios->save($usuario))
                $this->Flash->success(__('Se ha cambiado el estado del usuario (' . $usuario['nombre'] . ').'));

        } else {
            $this->Flash->error(__('No se puede cambiar el estado del Administrador'));
        }

        return $this->redirect(['action' => 'index']);

        $this->set('usuario', $usuario);
        $this->set('_serialize', ['usuario']);
    }
}
