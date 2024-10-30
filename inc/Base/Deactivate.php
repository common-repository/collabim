<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Base;

//Hook pro Deaktivaci pluginu

class Deactivate
{
    public static function deactivate () {
        flush_rewrite_rules();
    }
}