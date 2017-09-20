<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Beneficiario Entity
 *
 * @property int $id
 * @property float $monto_max
 * @property int $cant_max
 * @property float $monto_acumulado
 * @property int $cant_acumulada
 * @property \Cake\I18n\FrozenTime $ult_proceso
 * @property string $clave
 * @property int $usuario_id
 * @property int $cuenta_id
 * @property bool $vigente
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Cuenta $cuenta
 */
class Beneficiario extends Entity
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
        'monto_max' => true,
        'cant_max' => true,
        'monto_acumulado' => true,
        'cant_acumulada' => true,
        'ult_proceso' => true,
        'clave' => true,
        'usuario_id' => true,
        'cuenta_id' => true,
        'vigente' => true,
        'usuario' => true,
        'cuenta' => true
    ];
}
