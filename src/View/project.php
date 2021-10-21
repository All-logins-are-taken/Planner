<?php
include_once __DIR__ . '/Layout/header.php';

$h1 = 'Empty';
$output = '';
/** @var array $options */
if (!empty($options['project'])) {
    $h1 = $options['project']['title'];
    $images = unserialize($options['project']['images_paths']);
    $output.= '<canvas id="canvas" class="col-6"></canvas>';
    $output.= '<div class="row">';

    foreach ($images as $key => $image) {
        $output.= '<div class="col-1"><img id="img-' . $key . '" width="100" src="' . $image . '" alt="image" onclick="clipImageInPolygon(this)" /></div>';
    }
    $output.= '</div>';
    $output.= '<div>Hits: ' . $options['project']['hit'] . '</div>';
}
else {
    $output = 'Sorry something is wrong';
}

echo '      
    <header>      
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Planner project</a>
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
            <h1 class="mt-5">' . $h1 . '</h1>
            
'.$output;

include_once __DIR__ . '/Layout/footer.php';
