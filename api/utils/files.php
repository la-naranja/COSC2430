<?php

function saveUploadedFile($file, $targetDir)
{
    global $FAILED_UPLOADED_FILE_ERROR_CODE;

    $targetFile = $targetDir . basename($file["name"]);

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return "";
    }

    return errorResponse($FAILED_UPLOADED_FILE_ERROR_CODE);
}

function readCsvFile($path)
{
    if (($handle = fopen($path, "r")) !== false) {
        $result = array();
        while (($data = fgetcsv($handle, 0, "|")) !== false) {
            $result[] = $data;
        }
        fclose($handle);

        return $result;
    }

    return "";
}

function addDataToCsvFile($path, $data)
{
    try {
        $fp = fopen($path, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields,"|");
        }
        
        fclose($fp);
        
        return "";
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
