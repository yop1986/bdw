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
<div class="beneficiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($beneficiario) ?>
    <fieldset>
        <legend><?= __('Editar Beneficiario') ?></legend>
        <?php
            echo $this->Form->control('monto_max', ['label' => __('Monto Máximo')]);
            echo $this->Form->control('cant_max', [__('Cantidad Máxima de Transacciones')]);
            echo $this->Form->control('noCuenta', ['value' => $cuenta, 'readonly' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
