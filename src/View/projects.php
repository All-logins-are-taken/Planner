<?php
include_once __DIR__ . '/Layout/header.php';

$output = '';
/** @var array $options */
if (!empty($options['projects'])) {
    foreach (array_chunk($options['projects'], 8) as $list) {
        $output .= '<div class="row">';

        foreach ($list as $row)
        {
            $output.= '<div class="col-1 m-1">
                <a href="/project/' . $row['id'] . '">
                    <img height="100" src="' . $row["preview_path"] . '" alt="' . $row['title'] . '" />
                </a>
            </div>';
        }
        $output.= '</div>';
    }
}
else {
    $output = '<form id="import_form">
                    <button id="import_button" class="btn btn-info" type="button"  onclick="importProjects()">Import projects</button>
            </form>';
}

echo '      
    <header>      
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Planner projects</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>          
                <div class="collapse navbar-collapse" id="navbarCollapse">
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0 m-5">
        <div class="container">
            <h1 class="mt-5">Planner practical test with projects previews</h1>
            <div id="message"></div>
'.$output;

include_once __DIR__ . '/Layout/footer.php';
