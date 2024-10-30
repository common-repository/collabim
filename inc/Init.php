<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc;

//Incializační automatická funkce

use CollabimPluginInc\Base\Enqueue;
use CollabimPluginInc\Base\SettingsLinks;
use CollabimPluginInc\Pages\Admin;

final class Init
{
    /**
     * Store all classes inside an array
     * @return array Full list of classes
     */
// Seznam Class v zapsaných v poli pro inicializaci
    public static function getServices()
    {
        $admin = new Admin();
        $enqueue = new Enqueue();
        $settingsLinks = new SettingsLinks();

        return array(
            get_class($admin),
            get_class($enqueue),
            get_class($settingsLinks)
        );
    }

    /**
     * Loop through the classes, initialize the,
     * and call the register() method if it exists
     */
// Dynamická definice inicializace přes funkci "register"
    public static function registerServices()
    {
        foreach (self::getServices() as $class) {
            $service = self::instantiate ($class);
            if (method_exists($service,'register')){
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param class $class      class from the services array
     * @return class instance  new instance of the class
     */

    private static function instantiate($class)
    {
        $service = new $class();

        return $service;
    }

}

