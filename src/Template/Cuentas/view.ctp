<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Cuenta $cuenta
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    <?php if($Auth == 'Administrador'): ?>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Aprob. Depósitos'), ['controller' => 'Transacciones', 'action' => 'index']) ?></li>
    <?php else: ?>
        <li><?= $this->Html->link(__('Listar Beneficiarios'), ['controller' => 'Beneficiarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nuevo Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Transf. Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Depósito'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Estado de Cuenta'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
    <?php endif; ?>
    </ul>
</nav>
<div class="cuentas view large-9 medium-8 columns content">
    <h3><?= h($cuenta->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cuenta') ?></th>
            <td><?= h($cuenta->cuenta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Balance') ?></th>
            <td><?= $this->Number->currency($cuenta->balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reserva') ?></th>
            <td><?= $this->Number->currency($cuenta->reserva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($cuenta->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Titular') ?></th>
            <td><?= $cuenta->usuarios ? __($cuenta->usuarios[0]['nombre']) : __('Sin usuario asociado') ?></td>
        </tr>
    </table>
</div>
