<?php
/**
 * RUNALYZE
 *
 * @author Hannes Christiansen <mail@laufhannes.de>
 * @copyright http://runalyze.laufhannes.de/
 *
 * With this file you are able to install RUNALYZE.
 * Don't change anything in this file!
 */

require_once 'inc/html/class.Ajax.php';
require_once 'inc/system/class.PDOforRunalyze.php'; // TODO: Check if database class is really needed
require_once 'inc/system/class.DB.php'; // TODO: Check if database class is really needed
require_once 'inc/system/class.Request.php';
require_once 'inc/system/class.System.php';
require_once 'inc/class.Installer.php';

$Installer = new Installer();

$title = 'Installation: Runalyze '.RUNALYZE_VERSION;
include 'inc/tpl/tpl.installerHeader.php';

$Installer->display();

include 'inc/tpl/tpl.installerFooter.php';