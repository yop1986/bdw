<?php
$this->layout = false;
$cakeDescription = 'BDW Bank';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('guatemala', '/favicon.ico', ['type' => 'icon']) ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('bdw.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<nav class="top-bar expanded" data-topbar role="navigation">
    <div class="top-bar-section">
        <ul class="right">
            <li><?= $this->Html->link(__('Ingreso'), ['controller' => 'Usuarios', 'action' => 'login']) ?></li>
            <li><?= $this->Html->link(__('Registro'), ['controller' => 'Usuarios', 'action' => 'add']) ?></li>
        </ul>
    </div>
</nav>

<header class="row">
    <div class="header-image"><?= $this->Html->image('escudo-guatemala.png') ?></div>
    <div class="header-title">
        <h1>Banco de Desarrollo Web</h1>
    </div>
</header>

<div class="row">
    <div class="columns large-6">
        <h4>Misión</h4>
        <p>Ser un proyecto que cumpla con las funcionalidades requeridas, cumpliendo con las expectativas de lo solicitado en el documento formal del proyecto.</p>
    </div>
    <div class="columns large-6">
        <h4>Visión</h4>
        Ser un software, que cumpliendo con las medidas de seguridad tenga todos los elementos para ser un software útil y con calidad.
    </div>
    <hr />
</div>

<div class="row">
    <div class="columns large-12 text-center">
        <h3 class="more">Información</h3>
        <p>La apliación se desarrolla en el lenguaje PHP, utilizando una base de datos MySQL; adicional a esto se utiliza un framework llamado CakePHP que provee del core necesario para manejar los elementos y seguridad con un estilo de programación estandar.</p>
        <p>Esta página es un ejercicio empleado para poner en práctica y afianzar los conocimientos del curso de desarrollo web. No se pretente cubrir de forma amplia todos los aspectos de una página que simule todos los servicios bancarios, sino ejecutar funcionalidades específicas que incluyan elementos de programación variados.</p>
            <p>El banco de desarrollo web, consiste en un proyecto que permite llevar el control de ciertas operaciones de depósito en las cuentas asociadas a los clientes y permitir el movimiento entre cuentas de terceros asociadas previamente y verificadas por medio de un correo electrónico.</p>
    </div>
    <hr/>
</div>

</body>
</html>
