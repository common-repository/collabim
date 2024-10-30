<?php

/**
 * @package CollabimPlugin
 */

//Vypsání Collabim Widgetu přes Json
// 2 Inputy -> Api a ID projektu

namespace CollabimPluginInc\Api;

use CollabimPluginInc\Api\Callbacks\AdminCallbacks;

class ProjectPrint
{

    public function apiProjectPrint()
    {

        $project_select = new AdminCallbacks();

        $value = $project_select->valueSet();
        $project = $project_select->projectSet();

        $args = array(
            'headers' => array(
                'Accept' => 'application/collabim+json',
                'Authorization' => $value
            )
        );

        $response = wp_remote_retrieve_body( wp_remote_get("https://api.oncollabim.com/projects/$project/widget/fullWidget", $args));

        return $response;
// Funkce vrací finální grafický výstup widgetu
    }

}