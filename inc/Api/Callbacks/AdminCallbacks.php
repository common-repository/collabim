<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Api\Callbacks;

use CollabimPluginInc\Api\ProjectSelect;
use CollabimPluginInc\Base\BaseController;
use CollabimPluginInc\Api\ProjectPrint;

//Class s callbackami

class AdminCallbacks extends BaseController
{

    public $value;
    public $project;


    public function beforeApiSet()
    {
        global $wpdb;
        $wpdb->replace($wpdb->options, array('option_name' => 'check_first_api', 'option_value' => 'true'));
        $this->collabimApiSet();
    }


// Funkce pro nastavení hodnoty "Value"
    public function valueSet()
    {
        $this->value = esc_attr(get_option('api_set'));
        return $this->value;
    }

// Funkce pro nastavení hodnoty "Project"
    public function projectSet()
    {
        register_setting('collabim_api_set', 'project_select');
        $this->project = esc_attr(get_option('project_select'));
        return $this->project;
    }

// Funkce pro zjištění počtu polí(projektů) v poli "actives"
    public function projectSetLenght()
    {
        $project_select = new ProjectSelect();
        $response = $project_select->apiProjectFilter();
        $response_lenght = count($response);

        return $response_lenght;
    }

// Funkce přiřazuje šablonu hlavní položce v menu
    public function adminDashboard()
    {
        $this->value = esc_attr(get_option('api_set'));

        if (empty($this->value)) {
            return require_once("$this->plugin_path/templates/admin_before.php");

        } else {
            return require_once("$this->plugin_path/templates/admin_after.php");
        }
    }

// Funkce přiřazuje šablonu sub-položce v menu (nastavení)
    public function adminSettings()
    {
        return require_once("$this->plugin_path/templates/settings.php");
    }

// Callback Option Groupy
    public function collabimOptionsGroup($input)
    {
        return $input;
    }

// Callback Sekcí pro sub-položku (nastavení)
    public function collabimAdminSection($arguments)
    {
        $project_count = $this->projectSetLenght();

        switch ($arguments['id']) {
            case 'collabim_api_set':
                echo 'Svůj API klíč najdete v nastavení Vašeho uživatelského účtu 
                <br>
                <br>
                Po přihlášení do Collabimu v pravo nahoře v záložce "Mé údaje"';
                break;
            case 'collabim_project_select':

                if ($project_count > 1) {
                    echo "<h2>Výběr projektu</h2>";
                }
                break;
        }

    }

// Callback na položku inputu pro zadání API klíče na stránce "nastavení"
    public function collabimApiSet()
    {
        global $wpdb;
        $wpdb->replace($wpdb->options,array('option_name' => 'check_first_select', 'option_value' => 'true'));
        $check_first_api_bool = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'check_first_api'");

        $project_select = new ProjectSelect();
        $response_select = $project_select->apiProjectFilter();
        $project_print = new ProjectPrint();
        $response_print = $project_print->apiProjectPrint();
        $response_lenght = $this->projectSetLenght();
        $value = $this->valueSet();
        $this->value = esc_attr(get_option('api_set'));
        echo '<input type="text" class="regular-text" name="api_set" value="' . $this->value . '" placeholder="Zde zadejte svůj API klíč">';
// Podmínka pro vypsání chybného klíče na stránce "nastavení"

        if ($response_select == 'error') {
            if ($check_first_api_bool == 'false') {
                echo "<p style='color: red'>Chybný API klíč</p>";
            } else {
                $wpdb->update($wpdb->options, array('option_value' => 'false') ,array('option_name' => 'check_first_api'));
            }
        }
    }

// Callback pro selectbox projektů na stránce "nastavení"
    public function collabimProjectSelect() {
        global $wpdb;

        $check_first_project_bool = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'check_first_select'");
        $this->value = $this->valueSet();
        $response_lenght = $this->projectSetLenght();
        $project = $this->projectSet();

// Pokud není hodnota Api klíče prázdná
        if (!empty($this->value)) {
            $project_select = new ProjectSelect();
            $response = $project_select->apiProjectFilter();
            $i = 0;
            echo "<select name='project_select'>";
            echo "<option value='default'>Zvolte projekt</option>";
// Smyčka pro vypsání všech projektů do Selectu
            while ($i < $response_lenght) {
                $response_id = $response[$i]['id'];
                $response_name = $response[$i]['name'];
                ?>
                <option
                    value="<?php echo $response_id ?>" <?php if ($project == $response_id) echo 'selected="selected"' ?> > <?php echo $response_name ?>
                </option>
                <?php
                $i++;
            }
            echo "</select>";
// Pokud je hodnota projektu "default", či prázdná

            if ($check_first_project_bool == 'false') {
                if ($project == 'default') {
                    echo "<p style='color: red'>Není zvolený žádný projekt</p>";
                }
            } else {
                $wpdb->update($wpdb->options, array('option_value' => 'false') ,array('option_name' => 'check_first_select'));
            }
            register_setting('collabim_api_set', 'project_select');
            $this->project = esc_attr(get_option('project_select'));
        } else {
            echo "Pro zvolení projektu Zadejte API klíč";
        }
    }

}