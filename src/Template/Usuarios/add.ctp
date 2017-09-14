<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usuarios form large-9 medium-8 columns content">
    <?= $this->Form->create($usuario) ?>
    <fieldset>
        <legend><?= __('Add Usuario') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('correo', ['label' => __('Correo')]);
            echo $this->Form->control('telefono', ['label' => __('Telefono')]);
            echo $this->Form->control('contrasena', ['label' => __('Contraseña'), 'type' => 'password']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
