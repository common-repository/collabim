<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Base;

//Hook pro Aktivaci pluginu

class Activate
{
    public static function activate () {
        flush_rewrite_rules();
    }
}