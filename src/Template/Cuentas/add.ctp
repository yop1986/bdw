<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Sol. Depósitos'), ['controller' => 'Transferencias', 'action' => 'deposito']) ?></li>
    </ul>
</nav>
<div class="cuentas form large-9 medium-8 columns content">
    <?= $this->Form->create($cuenta) ?>
    <fieldset>
        <legend><?= __('Nueva Cuenta') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('cuenta', ['label' => __('Cuenta')]);
            echo $this->Form->control('balance', ['label' => __('Balance')]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
