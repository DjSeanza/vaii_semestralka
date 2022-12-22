<?php
namespace public\uploadFiles;

use App\Auth\LoginAuthenticator;
use public\toast\Errors;

class FileUpload
{
    const MAX_THUMBNAIL_SIZE = 500_000_000; // = 5MB
    const MAX_PROFILE_PICTURE_SIZE = 500_000_000; // = 5MB
    const MAX_CONTENT_SIZE = 3_000_000_000; // == 30MB
    const IMAGE_EXTENSIONS = array("jpeg", "jpg", "png", "svg", "webp");
    const VIDEO_EXTENSIONS = array("mp4");
    private FileDirectory $baseDirectory;
    private array $fileTypes;
    private string $userLogin;
    private array $files;

    /**
     * @throws \Exception
     */
    public function __construct(array $files, FileDirectory $baseDirectory, array $fileTypes, string $userLogin = null) {
        $auth = new LoginAuthenticator();
        $this->files = $files;
        $this->baseDirectory = $baseDirectory;
        $this->userLogin = ( $userLogin == null ? $auth->getLoggedUserName() : $userLogin );
        $this->fileTypes = $fileTypes;
    }

    public function uploadFile(): Errors|array {
        // TODO ak uploaduje dalsiu fotku, tak predoslu dat do nejakeho ineho suboru
        $fileTargetDirectory = $this->getDirectory();
        $directories = array();

        foreach ($this->files as $file) {
            $extension = pathinfo($file["name"],PATHINFO_EXTENSION);
            if (file_exists($fileTargetDirectory)) {
                return Errors::UNEXPECTED_ERROR;
            }

            if(!in_array(strtolower($extension), self::IMAGE_EXTENSIONS) &&
                !in_array(strtolower($extension), self::VIDEO_EXTENSIONS)) {
                return Errors::WRONG_FILE_FORMAT;
            }

            foreach ($this->fileTypes as $fileType) {
                if ($file["size"] > $this->maxFileSize($fileType)) {
                    return Errors::FILE_TOO_LARGE;
                }
            }

            // TODO delet eupload file ked zlyha
            if (move_uploaded_file($file["tmp_name"], $fileTargetDirectory . "." . $extension)) {
                $directories[] = $fileTargetDirectory . "." . $extension;
            } else {
                return Errors::FILE_NOT_UPLOADED;
            }
        }

        return $directories;
    }

    private function getDirectory(): string {
        $randomString = FileUpload::getRandomString();
        $randomUnixTimestamp = strtotime("now");
        $directoryToUpload = "";
        if ($this->baseDirectory == FileDirectory::PROFILE_PICTURE) {
            $directoryToUpload = $this->baseDirectory->value . $this->userLogin . "/";
        } else {
            $directoryToUpload = $this->baseDirectory->value . $this->userLogin . "/" . $randomUnixTimestamp . "_" . $randomString . "/";
        }

        if (!is_dir($directoryToUpload) && !mkdir($directoryToUpload)){
            die("Nepodarilo sa vytvoriť súbor: $directoryToUpload");
        }

        return $directoryToUpload . $randomUnixTimestamp . "_" . $randomString;
    }

    private function getRandomString() {
        return substr(
            str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 5)
            ), 0, 5);
    }

    private function maxFileSize(FileType $fileType): int {
        return match ($fileType) {
            FileType::THUMBNAIL => self::MAX_THUMBNAIL_SIZE,
            FileType::PROFILE_PICTURE => self::MAX_PROFILE_PICTURE_SIZE,
            FileType::VIDEO => self::MAX_CONTENT_SIZE
        };
    }
}