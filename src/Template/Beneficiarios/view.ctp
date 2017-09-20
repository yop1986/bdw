<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Beneficiario $beneficiario
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cuentas'), ['controller' => 'cuentas', 'action' => 'propias']) ?></li>
        <li><?= $this->Html->link(__('List Beneficiarios'), ['controller' => 'Beneficiarios', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="beneficiarios view large-9 medium-8 columns content">
    <h3><?= h($beneficiario->cuenta->cuenta) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Monto Máximo') ?></th>
            <td><?= $this->Number->format($beneficiario->monto_max) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cant. Máxima de Transacciones') ?></th>
            <td><?= $this->Number->format($beneficiario->cant_max) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monto Acumulado') ?></th>
            <td><?= $this->Number->format($beneficiario->monto_acumulado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cant. Acumulada') ?></th>
            <td><?= $this->Number->format($beneficiario->cant_acumulada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ultimo Proceso') ?></th>
            <td><?= h($beneficiario->ult_proceso) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado del Beneficiario') ?></th>
            <td><?= $beneficiario->vigente ? __('Confirmado') : __('Pendiente de Confirmar') ?></td>
        </tr>
    </table>
</div>
