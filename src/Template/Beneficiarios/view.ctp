<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Beneficiario $beneficiario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Beneficiario'), ['action' => 'edit', $beneficiario->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Beneficiario'), ['action' => 'delete', $beneficiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beneficiario->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Beneficiarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beneficiario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="beneficiarios view large-9 medium-8 columns content">
    <h3><?= h($beneficiario->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Clave') ?></th>
            <td><?= h($beneficiario->clave) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usuario') ?></th>
            <td><?= $beneficiario->has('usuario') ? $this->Html->link($beneficiario->usuario->nombre, ['controller' => 'Usuarios', 'action' => 'view', $beneficiario->usuario->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cuenta') ?></th>
            <td><?= $beneficiario->has('cuenta') ? $this->Html->link($beneficiario->cuenta->cuenta, ['controller' => 'Cuentas', 'action' => 'view', $beneficiario->cuenta->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($beneficiario->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monto Max') ?></th>
            <td><?= $this->Number->format($beneficiario->monto_max) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cant Max') ?></th>
            <td><?= $this->Number->format($beneficiario->cant_max) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monto Acumulado') ?></th>
            <td><?= $this->Number->format($beneficiario->monto_acumulado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cant Acumulada') ?></th>
            <td><?= $this->Number->format($beneficiario->cant_acumulada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ult Proceso') ?></th>
            <td><?= h($beneficiario->ult_proceso) ?></td>
        </tr>
    </table>
</div>
