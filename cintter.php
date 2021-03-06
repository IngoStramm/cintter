<?php

/**
 * Plugin Name: Cintter
 * Plugin URI: https://agencialaf.com
 * Description: Descrição do Cintter.
 * Version: 0.2.2
 * Author: Ingo Stramm
 * Text Domain: cintter
 * License: GPLv2
 */

defined('ABSPATH') or die('No script kiddies please!');

define('CINTTER_DIR', plugin_dir_path(__FILE__));
define('CINTTER_URL', plugin_dir_url(__FILE__));

require_once 'tgm/tgm.php';
require_once 'classes/classes.php';
require_once 'functions.php';
require_once 'scripts.php';
require_once 'cmb.php';
require_once 'woocommerce.php';

require 'plugin-update-checker-4.10/plugin-update-checker.php';
$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/IngoStramm/cintter/master/info.json',
    __FILE__,
    'cintter'
);
