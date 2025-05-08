<?php

class Utils
{
    public static function uploadImage(string $targetDir, string $fileInputName): ?string
    {
        $dir = rtrim($targetDir, '/');
        $uniqueName = uniqid() . "_" . basename($_FILES[$fileInputName]["name"]);
        $targetFile = $dir . "/" . $uniqueName;

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            return $targetFile;
        }

        return null;
    }
}
