<?php
    $tFilePath  = base64_decode($_GET['ptFile']);
    $tFileName  = basename($tFilePath);
    $tMimeType  = mime_content_type($tFilePath);

    header('Content-type: '.$tMimeType);
    header('Content-Disposition: attachment; filename='.$tFileName);
    readfile($tFilePath);
?>