<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Beneficiarios Model
 *
 * @property \App\Model\Table\UsuariosTable|\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\CuentasTable|\Cake\ORM\Association\BelongsTo $Cuentas
 *
 * @method \App\Model\Entity\Beneficiario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Beneficiario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Beneficiario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Beneficiario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Beneficiario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Beneficiario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Beneficiario findOrCreate($search, callable $callback = null, $options = [])
 */
class BeneficiariosTable extends Table
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

        $this->setTable('beneficiarios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->decimal('monto_max')
            ->requirePresence('monto_max', 'create')
            ->notEmpty('monto_max');

        $validator
            ->requirePresence('cant_max', 'create')
            ->notEmpty('cant_max');

        $validator
            ->decimal('monto_acumulado')
            ->requirePresence('monto_acumulado', 'create')
            ->notEmpty('monto_acumulado');

        $validator
            ->requirePresence('cant_acumulada', 'create')
            ->notEmpty('cant_acumulada');

        $validator
            ->dateTime('ult_proceso')
            ->requirePresence('ult_proceso', 'create')
            ->notEmpty('ult_proceso');

        $validator
            ->scalar('clave')
            ->requirePresence('clave', 'create')
            ->notEmpty('clave');

        $validator
            ->boolean('vigente')
            ->requirePresence('vigente', 'create')
            ->notEmpty('vigente');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['cuenta_id'], 'Cuentas'));

        return $rules;
    }
}
