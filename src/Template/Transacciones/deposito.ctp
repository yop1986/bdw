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
        <li><?= $this->Html->link(__('Depósito'), ['controller' => 'Transacciones', 'action' => 'deposito']) ?> </li>
        <li><?= $this->Html->link(__('Transf. Beneficiario'), ['controller' => 'Transacciones', 'action' => 'transferencia']) ?> </li>
    </ul>
</nav>
<div class="transacciones form large-9 medium-8 columns content">
    <?= $this->Form->create($transaccion) ?>
    <fieldset>
        <legend><?= __('Solicitud de Depósito') ?></legend>
        <?php
            echo $this->Form->control('monto');
            echo $this->Form->control('cuenta_id', ['options' => $cuentas]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
