<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $beneficiario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $beneficiario->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Beneficiarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="beneficiarios form large-9 medium-8 columns content">
    <?= $this->Form->create($beneficiario) ?>
    <fieldset>
        <legend><?= __('Edit Beneficiario') ?></legend>
        <?php
            echo $this->Form->control('monto_max');
            echo $this->Form->control('cant_max');
            echo $this->Form->control('monto_acumulado');
            echo $this->Form->control('cant_acumulada');
            echo $this->Form->control('ult_proceso');
            echo $this->Form->control('clave');
            echo $this->Form->control('usuario_id', ['options' => $usuarios]);
            echo $this->Form->control('cuenta_id', ['options' => $cuentas]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
