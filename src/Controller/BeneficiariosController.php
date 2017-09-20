<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
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

    public function isAuthorized($usuario) 
    {
        if (in_array($this->request->getParam('action'), ['index', 'add', 'edit', 'view', 'activacionBeneficiario']))
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
        $beneficiarios = $this->paginate($this->Beneficiarios);

        $this->set(compact('beneficiarios'));
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

        $this->set('beneficiario', $beneficiario);
        $this->set('_serialize', ['beneficiario']);
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
            $beneficiario->vigente = false;

            $this->Cuentas = TableRegistry::get('cuentas');
            $infoCuenta = (
                $this->Cuentas->find()
                    ->select(['id'])
                    ->where(['cuentas.cuenta' => $this->request->getData()['noCuenta']])
                )->first();

            if (!is_null($infoCuenta)) //existe la cuenta
            {
                $this->CuentasUsuarios = TableRegistry::get('cuentas_usuarios');
                $infoAsoc = (
                    $this->CuentasUsuarios->find()
                        ->select(['id'])
                        ->where(['cuentas_usuarios.cuenta_id' => $infoCuenta->id, 'cuentas_usuarios.usuario_id' => $this->Auth->User('id')])
                    )->first();

                if (is_null($infoAsoc)) //La cuenta no pertenece la usuario logueado
                {
                    $beneficiario->cuenta_id = $infoCuenta->id;
                    if ($this->Beneficiarios->save($beneficiario)) {
                        $this->Flash->success(__('The beneficiario has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The beneficiario could not be saved. Please, try again.'));
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
        $this->set('_serialize', ['beneficiario']);
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

    private function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
