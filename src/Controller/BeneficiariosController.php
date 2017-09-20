<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Beneficiarios Controller
 *
 * @property \App\Model\Table\BeneficiariosTable $Beneficiarios
 *
 * @method \App\Model\Entity\Beneficiario[] paginate($object = null, array $settings = [])
 */
class BeneficiariosController extends AppController
{

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
            if ($this->Beneficiarios->save($beneficiario)) {
                $this->Flash->success(__('The beneficiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The beneficiario could not be saved. Please, try again.'));
        }
        $usuarios = $this->Beneficiarios->Usuarios->find('list', ['limit' => 200]);
        $cuentas = $this->Beneficiarios->Cuentas->find('list', ['limit' => 200]);
        $this->set(compact('beneficiario', 'usuarios', 'cuentas'));
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
        $cuentas = $this->Beneficiarios->Cuentas->find('list', ['limit' => 200]);
        $this->set(compact('beneficiario', 'usuarios', 'cuentas'));
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
}
