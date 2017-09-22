<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Listar Beneficiarios'), ['controller' => 'Beneficiarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nuevo Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Transf. Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Depósito'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Estado de Cuenta'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cuentas form large-9 medium-8 columns content">
    <?= $this->Form->create($cuenta) ?>
    <fieldset>
        <legend><?= __('Editar Cuenta') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('cuenta', ['label' => __('Cuenta'), 'readonly' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
