<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Base;

//Class, která připojuje k pluginu styly a scripty

class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this,'enqueue'));
    }

    function enqueue () {
        wp_enqueue_style('collabimpluginstyle', $this->plugin_url . ('assets/style.css'));
        wp_enqueue_script('collabimpluginscript', $this->plugin_url . ('assets/script.js'));
    }
}