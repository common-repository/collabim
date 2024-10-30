<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Pages;

use CollabimPluginInc\Base\BaseController;
use CollabimPluginInc\Api\SettingsApi;
use CollabimPluginInc\Api\Callbacks\AdminCallbacks;

//Stránka v administraci

class Admin extends BaseController
{

    public $settings;

    public $callbacks;

    public $pages = array();

    public $subpages = array();

    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();

        $this->setPages();
        $this->setSubPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Přehled')->addSubPages($this->subpages)->register();
    }
// Nastavení stránek
    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'Collabim Plugin',
                'menu_title' => 'Collabim',
                'capability' => 'manage_options',
                'menu_slug' => 'collabim_plugin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => $this->plugin_url . 'assets/imgs/collabim-logo_small.png',
                'position' => 110
            )
        );
    }
// Nastavení Sub-stránek
    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'collabim_plugin',
                'page_title' => 'Nastavení',
                'menu_title' => 'Nastavení',
                'capability' => 'manage_options',
                'menu_slug' => 'collabim_sett',
                'callback' => array($this->callbacks, 'adminSettings')
            )
        );
    }
// Nastavení option group
    public function setSettings()
    {
        $args = array(
          array(
              'option_group' => 'collabim_options_group',
              'option_name' => 'api_set',
              'callback' => array($this->callbacks, 'collabimOptionsGroup')
          ),

            array(
              'option_group' => 'collabim_options_group',
              'option_name' => 'project_select',
              'callback' => array($this->callbacks, 'collabimOptionsGroup')
          )
        );

        $this->settings->setSettings($args);

    }
// Nastavení sekcí
    public function setSections()
    {
        $args = array(
            array(
                'id' => 'collabim_api_set',
                'title' => 'Zadání API kliče',
                'callback' => array($this->callbacks, 'collabimAdminSection'),
                'page' => 'collabim_sett'
            ),
            array(
                'id' => 'collabim_project_select',
                'title' => '',
                'callback' => array($this->callbacks, 'collabimAdminSection'),
                'page' => 'collabim_sett'
            )
        );

        $this->settings->setSections($args);

    }
// Nastavení položek v sekcích
    public function setFields()
    {
        $args = array(
            array(
                'id' => 'api_set',
                'title' => '',
                'callback' => array($this->callbacks, 'beforeApiSet'),
                'page' => 'collabim_sett',
                'section' => 'collabim_api_set',
                'args' => array(
                    'class' => 'example-class',
                    'label' => 'text_example'
                )),
                array(
                'id' => 'project_select',
                'title' => '',
                    'callback' => array($this->callbacks, 'collabimProjectSelect'),
                    'type' => 'select',
                'page' => 'collabim_sett',
                'section' => 'collabim_project_select',
                'options' => array(),
                    'args' => array(
                        'class' => 'select-class'

                    )


                )
        );

        $this->settings->setFields($args);

    }
    
}