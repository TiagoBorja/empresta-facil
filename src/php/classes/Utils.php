<?php

class Utils
{
    public static function uploadImage(string $targetDir, string $fileInputName): ?string
    {
        $dir = rtrim($targetDir, '/');
        $uniqueName = uniqid() . "_" . basename($_FILES[$fileInputName]["name"]);
        $targetFile = $dir . "/" . $uniqueName;

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); // Cria a pasta se não existir
        }

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            // Caminho relativo para uso no HTML
            return basename($dir) . "/" . $uniqueName;
        }

        return null;
    }

}
