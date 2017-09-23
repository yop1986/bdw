<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Cuenta[]|\Cake\Collection\CollectionInterface $cuentas
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Aprob. Depósitos'), ['controller' => 'Transacciones', 'action' => 'aprobar_depositos']) ?></li>
    </ul>
</nav>
<div class="cuentas index large-9 medium-8 columns content">
    <h3><?= __('Cuentas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nombre', ['label' => __('Nombre')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('cuenta', ['label' => __('Cuenta')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('balance', ['label' => __('Balance')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado', ['label' => __('Creado')]) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuentas as $cuenta): ?>
            <tr>
                <td><?= h($cuenta->nombre) ?></td>
                <td><?= h($cuenta->cuenta) ?></td>
                <td><?= $this->Number->currency($cuenta->balance) ?></td>
                <td><?= h($cuenta->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cuenta->id]) ?> |
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cuenta->id]) ?> |
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cuenta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuenta->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
