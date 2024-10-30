<?php

/**
 * @package CollabimPlugin
 */

//Main soubor pluginu

/*
 * Plugin Name: Collabim Plugin
 * Plugin URI: http://collabim.cz
 * Author: Collabim s.r.o
 * Version: 1.0.2
 * Description: Plugin, that connects Collabim to Wordpress
 * License: GPLv2
 */

/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Copyright 2005-2018 Automattic, Inc.
 */





defined('ABSPATH' ) or die ('K tomuto nemáte přístup!');

if (file_exists(dirname(__FILE__). '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}


// Hook pro Aktivaci
function activateCollabimPlugin() {
    CollabimPluginInc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activateCollabimPlugin');

// Hook pro Deaktivaci
function deactivateCollabimPlugin() {
    CollabimPluginInc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivateCollabimPlugin');

// Hook pro Inicializaci
if (class_exists('CollabimPluginInc\\Init')) {
    CollabimPluginInc\init::registerServices();
}