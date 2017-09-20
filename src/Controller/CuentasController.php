<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Cuentas Controller
 *
 * @property \App\Model\Table\CuentasTable $Cuentas
 *
 * @method \App\Model\Entity\Cuenta[] paginate($object = null, array $settings = [])
 */
class CuentasController extends AppController
{

    public function isAuthorized($usuario) 
    {
        if (in_array($this->request->getParam('action'), ['propias', 'view', 'edit']))
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
        $this->paginate = [];
        $cuentas = $this->paginate($this->Cuentas);

        $this->set(compact('cuentas'));
        $this->set('_serialize', ['cuentas']);
    }

    /**
     * Propias method
     *
     * @return \Cake\Http\Response|void
     */
    public function propias()
    {
        $this->paginate = [];
        $cuentas = $this->paginate($this->Cuentas->find('all')->join([
            [
                'table' => 'cuentas_usuarios', 
                'alias' => 'CtasUsrs',
                'type' => 'inner', 
                'conditions' => ['CtasUsrs.cuenta_id = Cuentas.id', 'CtasUsrs.usuario_id' => $this->Auth->User('id')]
            ]
        ]));

        $this->set(compact('cuentas'));
        $this->set('_serialize', ['cuentas']);
    }

    /**
     * View method
     *
     * @param string|null $id Cuenta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cuenta = $this->Cuentas->get($id, [
            'contain' => ['Usuarios']
        ]);

        if($this->Auth->User('grupo') == 'Administrador' or $this->Auth->User('id') == $cuenta->usuarios[0]->id) {
            $grupoAuth = $this->Auth->User('grupo');

            $this->set(compact('cuenta', 'grupoAuth'));
            //$this->set('_serialize', ['cuenta']);
        } else {
            $this->Flash->error(__('¡Solamente puede ver sus propias cuentas!'));
            $this->redirect(['action' => 'propias']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cuenta = $this->Cuentas->newEntity();
        if ($this->request->is('post')) {
            $cuenta = $this->Cuentas->patchEntity($cuenta, $this->request->getData());
            $cuenta['reserva'] = 0;
            $cuenta['creado'] = Time::Now();

            if ($this->Cuentas->save($cuenta)) {
                $this->Flash->success(__('The cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cuenta could not be saved. Please, try again.'));
        }
        $this->set(compact('cuenta'));
        $this->set('_serialize', ['cuenta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cuenta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cuenta = $this->Cuentas->get($id);
        $ctaNum = $cuenta['cuenta'];

        $grupoAuth = $this->Auth->User('grupo');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cuenta = $this->Cuentas->patchEntity($cuenta, $this->request->getData());
            $cuenta['cuenta'] = $ctaNum;
            
            if ($this->Cuentas->save($cuenta)) {
                $this->Flash->success(__('The cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cuenta could not be saved. Please, try again.'));
        }
        $this->set(compact('cuenta', 'grupoAuth'));
        $this->set('_serialize', ['cuenta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cuenta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cuenta = $this->Cuentas->get($id);
        if ($this->Cuentas->delete($cuenta)) {
            $this->Flash->success(__('The cuenta has been deleted.'));
        } else {
            $this->Flash->error(__('The cuenta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
