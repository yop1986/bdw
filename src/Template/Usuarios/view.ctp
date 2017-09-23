<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Usuario $usuario
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Aprob. Depósitos'), ['controller' => 'Transacciones', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="usuarios view large-9 medium-8 columns content">
    <h3><?= h($usuario->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Correo') ?></th>
            <td><?= h($usuario->correo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($usuario->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grupo') ?></th>
            <td><?= h($usuario->grupo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($usuario->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modificado') ?></th>
            <td><?= $usuario->modificado ? h($usuario->modificado) : __('Never') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= $usuario->activo ? __('Active') : __('Deactive'); ?></td>
        </tr>
    </table>
</div>
