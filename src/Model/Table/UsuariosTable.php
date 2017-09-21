<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 *
 * @property \App\Model\Table\CuentasTable|\Cake\ORM\Association\BelongsToMany $Cuentas
 *
 * @method \App\Model\Entity\Usuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Usuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Usuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usuario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Usuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Usuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usuario findOrCreate($search, callable $callback = null, $options = [])
 */
class UsuariosTable extends Table
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

        $this->setTable('usuarios');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Cuentas', [
            'foreignKey' => 'usuario_id',
            'targetForeignKey' => 'cuenta_id',
            'joinTable' => 'cuentas_usuarios'
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
            ->scalar('nombre')
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->scalar('correo')
            ->requirePresence('correo', 'create')
            ->notEmpty('correo')
            ->add('correo', 'validFormat', ['rule' => 'email', 'message' => __('¡Ingrese un correo válido!')])
            ->add('correo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('¡Correo ya registrado!')]);

        $validator
            ->scalar('telefono')
            ->requirePresence('telefono', 'create')
            ->notEmpty('telefono');

        $validator
            ->scalar('contrasena')
            ->requirePresence('contrasena', 'create')
            ->notEmpty('contrasena');

        $validator
            ->dateTime('creado')
            ->requirePresence('creado', 'create')
            ->notEmpty('creado');

        $validator
            ->dateTime('modificado')
            ->allowEmpty('modificado');

        $validator
            ->boolean('activo')
            ->requirePresence('activo', 'create')
            ->notEmpty('activo');

        $validator
            ->scalar('grupo')
            ->requirePresence('grupo', 'create')
            ->notEmpty('grupo');

        $validator
            ->scalar('clave')
            ->requirePresence('clave', 'create')
            ->notEmpty('clave');

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
        $rules->add($rules->isUnique(['correo']));

        return $rules;
    }

    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query
            ->select(['id', 'nombre', 'correo', 'contrasena', 'grupo'])
            ->where(['Usuarios.activo' => 1]);

        return $query;
    }
}
