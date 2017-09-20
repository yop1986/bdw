<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Beneficiario[]|\Cake\Collection\CollectionInterface $beneficiarios
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'cuentas', 'action' => 'propias']) ?></li>
        <li><?= $this->Html->link(__('New Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="beneficiarios index large-9 medium-8 columns content">
    <h3><?= __('Beneficiarios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('cuenta_id', __('Cuenta')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto_max', __('Monto Máximo')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('cant_max', __('Cantidad Máxima')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('ult_proceso', __('Ult. Actualización')) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beneficiarios as $beneficiario): ?>
            <tr>
                <td><?= h($beneficiario->cuenta->cuenta) ?></td>
                <td><?= $this->Number->currency($beneficiario->monto_max) ?></td>
                <td><?= $this->Number->format($beneficiario->cant_max) ?></td>
                <td><?= h($beneficiario->ult_proceso) ?></td>
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
