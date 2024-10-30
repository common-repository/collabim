<?php
// Šablona stránky "přehled" při podmínce, že je Api klíč zadaný
use CollabimPluginInc\Api\Callbacks\AdminCallbacks;
use CollabimPluginInc\Api\ProjectPrint;

$project_select = new AdminCallbacks();
$project_print = new ProjectPrint();

$value = $project_select->valueSet();
$project = $project_select->projectSet();
$project_lenght = $project_select->projectSetLenght();
$response = $project_print->apiProjectPrint();


// Pokud je hodnota projektu "default", či prázdná
if ($project == 'default' or empty($project)) {
    echo "<h2>Chyba výběru</h2>";
    echo "<p>Nevybrali jste žádný projekt</p><p>Projekt vyberte v nastavení</p>";
    echo "<a href=\"admin.php?page=collabim_sett\">Nastavení zde</a>";

} else {
// Pokud vypsaná hláška widgetu obsahuje určitý text
    if (strpos($response, 'API action does not exist')) {
        echo "<h2>Chyba Api klíče</h2>";
        echo "<p>Zkontrolujte v nastavení správnost Api klíče</p>";
        echo "<a href=\"admin.php?page=collabim_sett\">Nastavení zde</a>";

    } else {
        echo $response;
    }
}










