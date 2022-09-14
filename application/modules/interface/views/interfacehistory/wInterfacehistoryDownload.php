<?php

    $tFile      = base64_decode($_GET['ptFile']);
    $tPath      = base64_decode($_GET['ptPath']);
    $tFilePath  = $tPath . $tFile;
    // $tFilePath  = 'D:/AdaLinkMoshi/Export/Export/Success/'.$tFile.'.zip';
    $tFileName  = basename($tFilePath);

    $tMimeType = mime_content_type($tFilePath);
    header('Content-type: '.$tMimeType);
    header('Content-Disposition: attachment; filename='.$tFileName);
    readfile($tFilePath);

?>