<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'cuentas', 'action' => 'propias']) ?></li>
        <li><?= $this->Html->link(__('List Beneficiarios'), ['controller' => 'Beneficiarios', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="beneficiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($beneficiario) ?>
    <fieldset>
        <legend><?= __('Edit Beneficiario') ?></legend>
        <?php
            echo $this->Form->control('monto_max', ['label' => __('Monto Máximo')]);
            echo $this->Form->control('cant_max', [__('Cantidad Máxima de Transacciones')]);
            echo $this->Form->control('noCuenta', ['value' => $cuenta, 'readonly' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
