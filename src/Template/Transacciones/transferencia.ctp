<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Transacciones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="transacciones form large-9 medium-8 columns content">
    <?= $this->Form->create($transaccion) ?>
    <fieldset>
        <legend><?= __('Add Transaccion') ?></legend>
        <?php
            echo $this->Form->control('correlativo');
            echo $this->Form->control('monto');
            echo $this->Form->control('cuenta_id', ['options' => $cuentas]);
            echo $this->Form->control('estado');
            echo $this->Form->control('tipo');
            echo $this->Form->control('fechahora');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
