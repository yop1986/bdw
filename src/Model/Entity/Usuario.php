<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $correo
 * @property string $telefono
 * @property string $contrasena
 * @property \Cake\I18n\FrozenTime $creado
 * @property \Cake\I18n\FrozenTime $modificado
 * @property bool $activo
 * @property string $grupo
 * @property string $clave
 *
 * @property \App\Model\Entity\Cuenta[] $cuentas
 */
class Usuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _setContrasena ($pContrasena)
    {
        if (strlen($pContrasena) > 0) 
        {
            return (new DefaultPasswordHasher)->hash($pContrasena);
        }
    }
}
