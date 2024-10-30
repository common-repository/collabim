<?php

/**
 * @package CollabimPlugin
 */

namespace CollabimPluginInc\Api;

use CollabimPluginInc\Api\Callbacks\AdminCallbacks;
use CollabimPluginInc\Base\BaseController;

class ProjectSelect extends BaseController{
//Funkce na vypsaní listu projektu, registrovaných na Api klíči
    public function apiProjectSelect()
    {

        $project_select = new AdminCallbacks();
        $value = $project_select->valueSet();

        $args = array(
            'headers' => array(
                'Accept' => 'application/collabim+json',
                'Authorization' => $value
            )
        );

        $response = wp_remote_retrieve_body( wp_remote_get('https://api.oncollabim.com/projects', $args));

        $response = json_decode($response, true);

        return $response;
// vrací multidimenzionální pole s projekty
    }

// Funkce na vrácení pouze aktivních projektů tedy -> 'active' => '1'
    public function apiProjectFilter()
    {
        $response = $this->apiProjectSelect();
        if (isset($response['message'])) {

            $bad_api = "error";
            return $bad_api;

        } else {

            $actives = [];
            foreach ($response['data'] as $resp) {
                if($resp['active'] == 1) {
                    $actives[] = $resp;
                }
            }

            return $actives;
            // Vrací multidimenzionální pole s pouze aktivními projekty
        }


    }

}