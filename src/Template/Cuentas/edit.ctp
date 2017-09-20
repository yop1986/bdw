<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $grupoAuth == 'Cliente' ? $this->Html->link(__('List Cuentas'), ['action' => 'propias']) : $this->Html->link(__('List Cuentas'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="cuentas form large-9 medium-8 columns content">
    <?= $this->Form->create($cuenta) ?>
    <fieldset>
        <legend><?= __('Edit Cuenta') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('cuenta', ['label' => __('Cuenta'), 'readonly' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
