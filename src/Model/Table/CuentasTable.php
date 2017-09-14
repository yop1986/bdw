<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cuentas Model
 *
 * @property \App\Model\Table\UsuariosTable|\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\TransaccionesTable|\Cake\ORM\Association\HasMany $Transacciones
 *
 * @method \App\Model\Entity\Cuenta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cuenta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cuenta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cuenta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuenta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cuenta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cuenta findOrCreate($search, callable $callback = null, $options = [])
 */
class CuentasTable extends Table
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

        $this->setTable('cuentas');
        $this->setDisplayField('cuenta');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id'
        ]);
        $this->hasMany('Transacciones', [
            'foreignKey' => 'cuenta_id'
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
            ->scalar('nombre')
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->scalar('cuenta')
            ->requirePresence('cuenta', 'create')
            ->notEmpty('cuenta')
            ->add('cuenta', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->decimal('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

        $validator
            ->decimal('reserva')
            ->requirePresence('reserva', 'create')
            ->notEmpty('reserva');

        $validator
            ->dateTime('creado')
            ->requirePresence('creado', 'create')
            ->notEmpty('creado');

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
        $rules->add($rules->isUnique(['cuenta']));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
