<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transacciones Model
 *
 * @property \App\Model\Table\CuentasTable|\Cake\ORM\Association\BelongsTo $Cuentas
 *
 * @method \App\Model\Entity\Transaccion get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaccion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transaccion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaccion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaccion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaccion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaccion findOrCreate($search, callable $callback = null, $options = [])
 */
class TransaccionesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('transacciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cuentas', [
            'foreignKey' => 'cuenta_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->integer('correlativo')
            ->requirePresence('correlativo', 'create')
            ->notEmpty('correlativo');

        $validator
            ->decimal('monto')
            ->requirePresence('monto', 'create')
            ->notEmpty('monto');

        $validator
            ->scalar('estado')
            ->requirePresence('estado', 'create')
            ->notEmpty('estado');

        $validator
            ->scalar('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmpty('tipo');

        $validator
            ->dateTime('fechahora')
            ->requirePresence('fechahora', 'create')
            ->notEmpty('fechahora');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cuenta_id'], 'Cuentas'));

        return $rules;
    }
}
