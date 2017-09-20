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
        <legend><?= __('Add Beneficiario') ?></legend>
        <?php
            echo $this->Form->control('monto_max', ['label' => 'Monto Máximo']);
            echo $this->Form->control('cant_max', ['label' => 'Cantidad Máxima de Transacciones']);
            echo $this->Form->control('noCuenta', ['label' => 'No. Cuenta', 'required' => 'required']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
