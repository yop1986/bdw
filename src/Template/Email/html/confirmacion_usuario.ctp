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


echo '<p>No es necesario que responda a este correo, se ha generado de manera automática para proveer de un elnace que permita confirmar su correo.</p>';
echo '<p>Si ha recibido este correo por error, por favor ignore su contenido.</p>';
echo '<p>Para confirmar el correo por favor presione el siguiente enlace: '. $this->Html->link(__('Confirmación de Usuario'), $contenido) .'</p>';
