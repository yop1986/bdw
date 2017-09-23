<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaccion Entity
 *
 * @property int $id
 * @property int $correlativo
 * @property float $monto
 * @property int $cuenta_id
 * @property string $estado
 * @property string $tipo
 * @property \Cake\I18n\FrozenTime $fechahora
 *
 * @property \App\Model\Entity\Cuenta $cuenta
 */
class Transaccion extends Entity
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
}
