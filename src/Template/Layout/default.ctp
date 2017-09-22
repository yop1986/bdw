<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'BDW - El banco de confianza';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
        <?php if (isset($Auth) and ($Auth === 'Administrador')): ?>
            <li class="name"><h1>
                <?= $this->Html->link(__('Panel Administrador'), ['controller' => 'Usuarios', 'action' => 'index']) ?>
            </h1></li>
        <?php elseif (isset($Auth) and ($Auth === 'Cliente')): ?>
            <li class="name"><h1>
                <?= $this->Html->link(__('Panel Cliente'), ['controller' => 'Cuentas', 'action' => 'propias']) ?>
            </h1></li>
        <?php endif; ?>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <?php if (isset($Auth)): ?>
                <li><?= $this->Html->link(__('Perfil'), ['controller' => 'Usuarios', 'action' => 'edit']) ?></li>
                <li><?= $this->Html->link(__('Salir'), ['controller' => 'Usuarios', 'action' => 'logout']) ?></li>
            <?php else: ?>
                <li><?= $this->Html->link(__('Inicio'), ['controller' => 'Pages', 'action' => 'home']) ?></li>
            <?php endif; ?>
                <!--<li><a target="_blank" href="https://book.cakephp.org/3.0/">Documentation</a></li>
                <li><a target="_blank" href="https://api.cakephp.org/3.0/">API</a></li>-->
                
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
