<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Cuenta $cuenta
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="cuentas view large-9 medium-8 columns content">
    <h3><?= h($cuenta->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cuenta') ?></th>
            <td><?= h($cuenta->cuenta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Balance') ?></th>
            <td><?= $this->Number->currency($cuenta->balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reserva') ?></th>
            <td><?= $this->Number->currency($cuenta->reserva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($cuenta->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Titular') ?></th>
            <td><?= $cuenta->usuarios ? __($cuenta->usuarios[0]['nombre']) : __('Sin usuario asociado') ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Transacciones') ?></h4>
        <?php if (!empty($cuenta->transacciones)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Correlativo') ?></th>
                <th scope="col"><?= __('Monto') ?></th>
                <th scope="col"><?= __('Cuenta Id') ?></th>
                <th scope="col"><?= __('Estado') ?></th>
                <th scope="col"><?= __('Tipo') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($cuenta->transacciones as $transacciones): ?>
            <tr>
                <td><?= h($transacciones->id) ?></td>
                <td><?= h($transacciones->correlativo) ?></td>
                <td><?= h($transacciones->monto) ?></td>
                <td><?= h($transacciones->cuenta_id) ?></td>
                <td><?= h($transacciones->estado) ?></td>
                <td><?= h($transacciones->tipo) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Transacciones', 'action' => 'view', $transacciones->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Transacciones', 'action' => 'edit', $transacciones->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transacciones', 'action' => 'delete', $transacciones->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transacciones->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
