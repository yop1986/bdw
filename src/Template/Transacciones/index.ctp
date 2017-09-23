<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Transaccion[]|\Cake\Collection\CollectionInterface $transacciones
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Aprob. Depósitos'), ['controller' => 'Transacciones', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="transacciones index large-9 medium-8 columns content">
    <h3><?= __('Transacciones') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('correlativo', __('Correlativo')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto', __('Monto')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('cuenta_id', __('Cuenta')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('estado', __('Estado')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('fechahora', __('Fecha/Hora')) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacciones as $transaccion): ?>
            <tr>
                <td><?= $this->Number->format($transaccion->correlativo) ?></td>
                <td><?= $this->Number->currency($transaccion->monto) ?></td>
                <td><?= $transaccion->has('cuenta') ? $this->Html->link($transaccion->cuenta->cuenta, ['controller' => 'Cuentas', 'action' => 'view', $transaccion->cuenta->id]) : '' ?></td>
                <td><?= h($transaccion->estado) ?></td>
                <td><?= h($transaccion->fechahora) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Autorizar'), ['action' => 'autoriza_deposito', $transaccion->id]) ?> | 
                    <?= $this->Html->link(__('Rechazar'), ['action' => 'rechaza_deposito', $transaccion->id]) ?>
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
