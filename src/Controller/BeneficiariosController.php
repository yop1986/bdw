<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry; 

/**
 * Beneficiarios Controller
 *
 * @property \App\Model\Table\BeneficiariosTable $Beneficiarios
 *
 * @method \App\Model\Entity\Beneficiario[] paginate($object = null, array $settings = [])
 */
class BeneficiariosController extends AppController
{
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['activacionBeneficiario']);
    }

    public function isAuthorized($usuario) 
    {
        return true;
        
        return parent::isAuthorized($usuario);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Usuarios', 'Cuentas']
        ];
        $beneficiarios = $this->paginate(
            $this->Beneficiarios
                ->find()
                ->where(['beneficiarios.usuario_id' => $this->Auth->User('id')])
            );

        $this->set(compact('beneficiarios'));
        $this->set('Auth', $this->Auth->User('grupo'));
        $this->set('_serialize', ['beneficiarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Beneficiario id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $beneficiario = $this->Beneficiarios->get($id, [
            'contain' => ['Usuarios', 'Cuentas']
        ]);

        if ($this->Auth->User('grupo') === 'Administrador' or $this->Auth->User('id') == $beneficiario->usuario_id)
        {
            $this->set('beneficiario', $beneficiario);
            $this->set('Auth', $this->Auth->User('grupo'));
            $this->set('_serialize', ['beneficiario']);
        }else{
            $this->Flash->error(__('¡Solamente puede ver los beneficiarios asociados a su cuenta!'));
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $beneficiario = $this->Beneficiarios->newEntity();
        if ($this->request->is('post')) {
            $beneficiario = $this->Beneficiarios->patchEntity($beneficiario, $this->request->getData());
            $beneficiario->monto_acumulado = 0;
            $beneficiario->cant_acumulada = 0;
            $beneficiario->ult_proceso = Time::Now();
            $beneficiario->clave = $this->generateRandomString();
            $beneficiario->usuario_id = $this->Auth->User('id');
            $beneficiario->vigente = 1;

            $noCuenta = $this->request->getData()['noCuenta'];

            $this->Cuentas = TableRegistry::get('cuentas');
            $idCuenta = (
                $this->Cuentas->find()
                    ->select(['id'])
                    ->where(['cuentas.cuenta' => $noCuenta])
                )->first()->id;

            if (!is_null($idCuenta)) //existe la cuenta
            {
                $this->checkBenef = TableRegistry::get('beneficiarios');
                $idBenef = (
                    $this->checkBenef->find()
                        ->select(['id'])
                        ->where(['beneficiarios.cuenta_id' => $idCuenta, 'beneficiarios.usuario_id' => $this->Auth->User('id')])
                )->first();

                if (!is_null($idBenef)){
                    $this->Flash->error(__('La cuenta ya es beneficiaria del usuario.'));
                    return $this->redirect(['action' => 'index']);
                }

                $this->CuentasUsuarios = TableRegistry::get('cuentas_usuarios');
                $infoAsoc = (
                    $this->CuentasUsuarios->find()
                        ->select(['id'])
                        ->where(['cuentas_usuarios.cuenta_id' => $idCuenta, 'cuentas_usuarios.usuario_id' => $this->Auth->User('id')])
                    )->first();

                if (is_null($infoAsoc)) //La cuenta no pertenece la usuario logueado
                {
                    $beneficiario->cuenta_id = $idCuenta;
                    if ($this->Beneficiarios->save($beneficiario)) {

                        if (!$beneficiario->vigente)
                        {
                            $email = new Email();
                            $email
                                ->subject('Confirmación para Asociacion de Beneficiario')
                                ->template('confirmacion_beneficiario', 'default')
                                ->emailFormat('html')
                                ->to($this->Auth->User('correo'))
                                ->viewVars(['contenido' => ['controller' => 'Beneficiarios', 'action' => 'activacion-beneficiario', $noCuenta, $beneficiario->clave, '_full' => true]])
                                ->send();
                        }

                        $this->Flash->success(__('El beneficiario fue guardado, por favor confirme desde su correo.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('El beneficiario no fue guardado, por favor intente de nuevo.'));
                }
                else
                {
                    $this->Flash->error(__('¡La Cuenta pertenece al usuario!.'));
                }
            }
            else
            {
                $this->Flash->error(__('¡La Cuenta no existe!.'));
            }
            /*
            
            */
        }
        $this->set(compact('beneficiario'));
        $this->set('Auth', $this->Auth->User('grupo'));
        $this->set('_serialize', ['beneficiario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Beneficiario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $beneficiario = $this->Beneficiarios->get($id, [
            'contain' => []
        ]);
        if ($this->Auth->User('grupo') === 'Administrador' or $this->Auth->User('id') == $beneficiario->usuario_id)
        {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $beneficiario = $this->Beneficiarios->patchEntity($beneficiario, $this->request->getData());
                if ($this->Beneficiarios->save($beneficiario)) {
                    $this->Flash->success(__('The beneficiario has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The beneficiario could not be saved. Please, try again.'));
            }
            $usuarios = $this->Beneficiarios->Usuarios->find('list', ['limit' => 200]);
            $cuenta = $this->Beneficiarios->Cuentas->get($beneficiario->cuenta_id)->cuenta;
            $this->set(compact('beneficiario', 'cuenta'));
            $this->set('Auth', $this->Auth->User('grupo'));
            $this->set('_serialize', ['beneficiario']);
        }else{
            $this->Flash->error(__('¡Solamente puede editar los beneficiarios asociados a su cuenta!'));
            $this->redirect(['action' => 'index']);
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Beneficiario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $beneficiario = $this->Beneficiarios->get($id);
        if ($this->Beneficiarios->delete($beneficiario)) {
            $this->Flash->success(__('The beneficiario has been deleted.'));
        } else {
            $this->Flash->error(__('The beneficiario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function activacionBeneficiario($cuenta, $clave)
    {
        $this->Cuentas = TableRegistry::get('cuentas');
        $idCuenta = (
            $this->Cuentas->find()
                ->select(['id'])
                ->where(['cuentas.cuenta' => $cuenta])
            )->first()->id;


        $this->Beneficiarios = TableRegistry::get('beneficiarios');
        $beneficiario = (
            $this->Beneficiarios->find()
                ->select(['id'])
                ->where(['beneficiarios.cuenta_id' => $idCuenta, 'beneficiarios.clave' => $clave])
            )->first();

        // Existe la solicitud para agregar beneficiario
        if (!is_null($beneficiario)) {
            $beneficiario = $this->Beneficiarios->patchEntity($beneficiario, $this->request->getData());
            $beneficiario->clave = '';
            $beneficiario->vigente = true;

            if ($this->Beneficiarios->save($beneficiario)) {
                $this->Flash->success(__('El beneficiario ha sido activado'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No fue posible activar al beneficiario. Intente de nuevo ó verifique el enlace.'));
            
        }

        //var_dump($beneficiario); exit;
    }
}
