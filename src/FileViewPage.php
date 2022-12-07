<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class FileViewPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        session_start();

        if(empty($_SESSION) || !isset($_GET['id_info'])) {
            header('location: /');
            exit;
        }
        $id_info = (int)$_GET['id_info'];

        $database_pdo = Tables\Database::get_connection();
        $file_resource = Tables\InfoFiles::select($database_pdo, $id_info);
        $mime_type = Tables\Infos::select_mime_type($database_pdo, $id_info);

        if(empty($mime_type)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_buffer($finfo, $file_resource, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
        }

        return $output
            ->withMetadata(
                'Content-Type',
                $mime_type
            )
            ->withMetadata(
                PageInterface::BODY,
                stream_get_contents($file_resource)
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}