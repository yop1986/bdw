<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Beneficiario[]|\Cake\Collection\CollectionInterface $beneficiarios
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Beneficiario'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="beneficiarios index large-9 medium-8 columns content">
    <h3><?= __('Beneficiarios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto_max') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cant_max') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto_acumulado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cant_acumulada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ult_proceso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('clave') ?></th>
                <th scope="col"><?= $this->Paginator->sort('usuario_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cuenta_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beneficiarios as $beneficiario): ?>
            <tr>
                <td><?= $this->Number->format($beneficiario->id) ?></td>
                <td><?= $this->Number->format($beneficiario->monto_max) ?></td>
                <td><?= $this->Number->format($beneficiario->cant_max) ?></td>
                <td><?= $this->Number->format($beneficiario->monto_acumulado) ?></td>
                <td><?= $this->Number->format($beneficiario->cant_acumulada) ?></td>
                <td><?= h($beneficiario->ult_proceso) ?></td>
                <td><?= h($beneficiario->clave) ?></td>
                <td><?= $beneficiario->has('usuario') ? $this->Html->link($beneficiario->usuario->nombre, ['controller' => 'Usuarios', 'action' => 'view', $beneficiario->usuario->id]) : '' ?></td>
                <td><?= $beneficiario->has('cuenta') ? $this->Html->link($beneficiario->cuenta->cuenta, ['controller' => 'Cuentas', 'action' => 'view', $beneficiario->cuenta->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $beneficiario->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $beneficiario->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $beneficiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beneficiario->id)]) ?>
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
