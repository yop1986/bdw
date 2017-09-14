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
                ['action' => 'delete', $usuario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usuarios form large-9 medium-8 columns content">
    <?= $this->Form->create($usuario) ?>
    <fieldset>
        <legend><?= __('Edit Usuario') ?></legend>
        <?php
            echo $this->Form->control('nombre', ['label' => __('Nombre')]);
            echo $this->Form->control('correo', ['label' => __('Correo')]);
            echo $this->Form->control('telefono', ['label' => __('Telefono')]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
