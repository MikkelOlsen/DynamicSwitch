<?php 
    exec('git log -1',$line);

    $myVersion = "    V 0.1.3 (Alpha)";
    $newVersion = $line[4];
    if($myVersion !== $newVersion) {
        $versionError = '<div class="alert alert-warning">Der findes en nyere version</div>';
    }


?>


<h1>Website Installer - <?= $myVersion ?></h1><?= @$versionError ?>