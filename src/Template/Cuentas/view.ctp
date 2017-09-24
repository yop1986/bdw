<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Cuenta $cuenta
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    <?php if($Auth == 'Administrador'): ?>
        <li><?= $this->Html->link(__('Listar Cuentas'), ['controller' => 'Cuentas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nueva Cuenta'), ['controller' => 'Cuentas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Aprob. Depósitos'), ['controller' => 'Transacciones', 'action' => 'index']) ?></li>
    <?php else: ?>
        <li><?= $this->Html->link(__('Listar Beneficiarios'), ['controller' => 'Beneficiarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nuevo Beneficiario'), ['controller' => 'Beneficiarios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Depósito'), ['controller' => 'Transacciones', 'action' => 'deposito']) ?> </li>
        <li><?= $this->Html->link(__('Transf. Beneficiario'), ['controller' => 'Transacciones', 'action' => 'transferencia']) ?> </li>
    <?php endif; ?>
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
</div>

<?php if (empty($transacciones)): ?>
<div class="cuentas view large-9 medium-8 columns content">
    <h4><?= __('Estado de Cuenta (Movimientos)') ?></h4>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('correlativo', ['label' => __('Correlativo')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('monto', ['label' => __('Monto')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo', ['label' => __('Tipo')]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('fehcahora', ['label' => __('Fecha/Hora')]) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($transacciones as $trn): ?>
            <tr>
                <td><?= $trn['correlativo'] ?></td>
                <td><?= $this->number->currency($trn['monto']) ?></td>
                <td><?= $trn['tipo'] ?></td>
                <td><?= $trn['fechahora'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>