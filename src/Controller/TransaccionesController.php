<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry; 

/**
 * Transacciones Controller
 *
 * @property \App\Model\Table\TransaccionesTable $Transacciones
 *
 * @method \App\Model\Entity\Transaccion[] paginate($object = null, array $settings = [])
 */
class TransaccionesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        //$this->Auth->allow(['add', 'activacionUsuario']);
    }

    public function isAuthorized($usuario) 
    {
        if (in_array($this->request->getParam('action'), ['deposito', 'transferencia']))
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
            'contain' => ['Cuentas']
        ];
        $transacciones = $this->paginate($this->Transacciones->find('all')->where(['Transacciones.estado' => 'Solicitado', 'Transacciones.tipo' => 'Deposito']));

        $this->set(compact('transacciones'));
        $this->set('Auth', $this->Auth->User('grupo'));
        $this->set('_serialize', ['transacciones']);
    }

    public function deposito()
    {
        $transaccion = $this->Transacciones->newEntity();
        if ($this->request->is('post')) {
            $correlativo = TableRegistry::get('transacciones')->find()->select(['correlativo' => 'MAX(correlativo)'])->max('correlativo')->correlativo;

            $transaccion = $this->Transacciones->patchEntity($transaccion, $this->request->getData());
            $transaccion->correlativo = $correlativo + 1;
            $transaccion->estado = 'Solicitado';
            $transaccion->tipo = 'Deposito';
            $transaccion->fechahora = Time::Now();

            if ($this->Transacciones->save($transaccion)) {
                $this->Flash->success(__('Se ha realizado el depósito, pendiente la confirmación del administrador.'));

                return $this->redirect(['controller' => 'Cuentas', 'action' => 'propias']);
            }
            $this->Flash->error(__('El depósito no se pudo realizar, por favor intente de nuevo.'));
        }
        $cuentas = $this->Transacciones->Cuentas->find('list', ['limit' => 200])->join( [
                'table' => 'cuentas_usuarios', 
                'alias' => 'CtasUsrs',
                'type' => 'inner', 
                'conditions' => ['CtasUsrs.cuenta_id = Cuentas.id', 'CtasUsrs.usuario_id' => $this->Auth->User('id')]
            ]);
        $this->set(compact('transaccion', 'cuentas'));
        $this->set('Auth', $this->Auth->User('grupo'));
        $this->set('_serialize', ['transaccion']);
    }

    public function autorizaDeposito($id = null)
    {
        $transaccion = TableRegistry::get('transacciones')->find()->where('transacciones.id = ' . $id)->first();

        if ($transaccion->estado == 'Solicitado' and $transaccion->tipo == 'Deposito') {
            $transaccion->estado = 'Autorizado';
            $transaccion = $this->Transacciones->patchEntity($transaccion, []);

            if ($this->Transacciones->save($transaccion)){
                $this->Flash->success(__('Se ha autorizado el depósito.'));
            } else {
                $this->Flash->error(__('No se pudo autorizar el depósito, intente de nuevo.'));
            }
        } else {
            $this->Flash->error(__('Depósito no valido, seleccione de la lista o contacte al administador.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function rechazaDeposito($id = null)
    {
        $transaccion = TableRegistry::get('transacciones')->find()->where('transacciones.id = ' . $id)->first();

        if ($transaccion->estado == 'Solicitado' and $transaccion->tipo == 'Deposito') {
            $transaccion->estado = 'Rechazado';
            $transaccion = $this->Transacciones->patchEntity($transaccion, []);

            if ($this->Transacciones->save($transaccion)){
                $this->Flash->success(__('Se ha rechazado el depósito.'));
            } else {
                $this->Flash->error(__('No se pudo rechazar el depósito, intente de nuevo.'));
            }
        } else {
            $this->Flash->error(__('Depósito no valido, seleccione de la lista o contacte al administador.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function transferencia()
    {
        $transaccion = $this->Transacciones->newEntity();

        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $trTransacciones = TableRegistry::get('transacciones');
            
            $correlativo = $trTransacciones->find()->select(['correlativo' => 'MAX(correlativo)'])->max('correlativo')->correlativo + 1;
            $fechahora = Time::Now();

            $stmt = $conn->prepare('SELECT balance FROM cuentas WHERE id = :id');
            $stmt->bind(['id' => $this->request->getData()['cuenta_id']], ['id' => 'integer']);
            $stmt->execute();

            if ($stmt->fetch('assoc')['balance'] >= $this->request->getData()['monto']){
                $conn->begin();
                
                $stmt = $conn->prepare('INSERT INTO transacciones (correlativo, monto, cuenta_id, estado, tipo, fechahora) 
                    VALUES (:correlativo, :monto, :cuenta_id, :estado, :tipo, :fechahora)');
                $stmt->bind([
                    'correlativo' => $correlativo,
                    'monto' => -$this->request->getData()['monto'],
                    'cuenta_id' => $this->request->getData()['cuenta_id'],
                    'estado' => 'Autorizado',
                    'tipo' => 'Transferencia',
                    'fechahora' => $fechahora
                ],
                [
                    'correlativo' => 'integer',
                    'monto' => 'decimal',
                    'cuenta_id' => 'integer',
                    'estado' => 'string',
                    'tipo' => 'string',
                    'fechahora' => 'datetime'
                ]);
                $stmt->execute();

                $stmt->bind(
                [
                    'correlativo' => $correlativo,
                    'monto' => $this->request->getData()['monto'],
                    'cuenta_id' => $this->request->getData()['ctaDestino'],
                    'estado' => 'Autorizado',
                    'tipo' => 'Transferencia',
                    'fechahora' => $fechahora,
                ],
                [
                    'correlativo' => 'integer',
                    'monto' => 'decimal',
                    'cuenta_id' => 'integer',
                    'estado' => 'string',
                    'tipo' => 'string',
                    'fechahora' => 'datetime'
                ]);
                $stmt->execute();

                $stmt = $conn->prepare('UPDATE cuentas SET balance = balance - :monto WHERE id = :id;');
                $stmt->bind(
                    ['monto' => $this->request->getData()['monto'], 'id' => $this->request->getData()['cuenta_id']], 
                    ['monto' => 'decimal', 'id' => 'integer']
                );
                $stmt->execute();

                $stmt = $conn->prepare('UPDATE cuentas SET balance = balance + :monto WHERE id = :id;');
                $stmt->bind(
                    ['monto' => $this->request->getData()['monto'], 'id' => $this->request->getData()['ctaDestino']], 
                    ['monto' => 'decimal', 'id' => 'integer']
                );
                $stmt->execute();


                //var_dump($stmt); exit;
                $conn->commit();
            } else {
                $this->Flash->error('No tiene dinero disponible para la transaccion.');
            }
            
            /*


            $transaccion = $this->Transacciones->patchEntity($transaccion, $this->request->getData());
            $transaccion->correlativo = $correlativo + 1;
            $transaccion->estado = 'Autorizado';
            $transaccion->tipo = 'Transferencia';
            $transaccion->fechahora = Time::Now();

            unset($transaccion->ctaDestino);

            var_dump($transaccion); exit;
            if ($this->Transacciones->save($transaccion)) {
                $this->Flash->success(__('The transaccion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The transaccion could not be saved. Please, try again.'));
            */
        }
        $cuentas = $this->Transacciones->Cuentas->find('list', ['limit' => 200])->join( [
            'table' => 'cuentas_usuarios', 
            'alias' => 'CtasUsrs',
            'type' => 'inner', 
            'conditions' => ['CtasUsrs.cuenta_id = Cuentas.id', 'CtasUsrs.usuario_id' => $this->Auth->User('id')]
        ]);
        $ctasDestino = TableRegistry::get('beneficiarios')->Cuentas->find('list')->join([
            'table' => 'beneficiarios',
            'alias' => 'Benef',
            'type' => 'inner', 
            'conditions' => ['Cuentas.id = Benef.cuenta_id', 'Benef.usuario_id' => $this->Auth->User('id')]
        ]);
        //var_dump($ctasDestino); exit;
        /*$ctasDestino = $this->Transacciones->Cuentas->find('list', ['limit' => 200])->join( [
                'table' => 'cuentas_usuarios', 
                'alias' => 'CtasUsrs',
                'type' => 'inner', 
                'conditions' => ['CtasUsrs.cuenta_id = Cuentas.id', 'CtasUsrs.usuario_id' => $this->Auth->User('id')]
            ]);
            */
        $this->set(compact('transaccion', 'cuentas', 'ctasDestino'));
        $this->set('_serialize', ['transaccion']);
    }
}
