<?php
/**
  * @var \App\View\AppView $this
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
<div class="usuarios form large-9 medium-8 columns content">
    <?= $this->Form->create($usuario) ?>
    <fieldset>
        <legend><?= __('Editar Perfil') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('correo', ['label' => __('Correo')]);
            echo $this->Form->control('telefono', ['label' => __('Telefono')]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
