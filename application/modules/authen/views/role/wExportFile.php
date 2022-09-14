<?php
    $tFile      = $_GET['ptFile'];
    $tFilePath  = 'Export/'.$tFile.'.json';
    $tFileName  = basename($tFilePath);
    $tMimeType  = mime_content_type($tFilePath);
    header('Content-type: '.$tMimeType);
    header('Content-Disposition: attachment; filename='.$tFileName);
    readfile($tFilePath);

    unlink($tFilePath);
?>