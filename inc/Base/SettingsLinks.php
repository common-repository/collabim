<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Base;

//Class s odkazem na stránku "nastavení" na přehledu plufinů

class SettingsLinks extends BaseController
{

    public function register ()
    {
        add_filter('plugin_action_links_' . $this->plugin ,array($this, 'settingsLink'));
    }

    public function settingsLink($link)
    {
        $settings_link = '<a href="admin.php?page=collabim_sett">Nastavení</a>';
        array_push($link, $settings_link);
        return $link;
    }



}