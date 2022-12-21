<?php
namespace public\uploadFiles;

use App\Auth\LoginAuthenticator;
use public\errors\Errors;

class FileUpload
{
    const MAX_THUMBNAIL_SIZE = 500_000_000; // 500 000 000B = 5MB
    const MAX_PROFILE_PICTURE_SIZE = 500_000_000; // 500 000 000B = 5MB
    const MAX_CONTENT_SIZE = 500_000_000;
    const IMAGE_EXTENSIONS = array("jpeg", "jpg", "png", "svg");
    const VIDEO_EXTENSIONS = array("mp4", "3gp");
    private FileDirectory $baseDirectory;
    private string $userLogin;
    private string|null $contentName;
    private string $extension;
    private array $file;
    private int $maxFileSize;

    /**
     * @throws \Exception
     */
    public function __construct(array $file, FileDirectory $baseDirectory, FileType $fileType, string $userLogin = null, string $contentName = null) {
        $auth = new LoginAuthenticator();
        $this->file = $file;
        $this->baseDirectory = $baseDirectory;
        $this->userLogin = ( $userLogin == null ? $auth->getLoggedUserName() : $userLogin );
        $this->contentName = $contentName;
        $this->extension = $this->getExtension();
        $this->maxFileSize($fileType);
    }

    public function uploadFile(): Errors|string {
        // TODO ak uploaduje dalsiu fotku, tak predoslu dat do nejakeho ineho suboru
        $fileTargetDirectory = $this->getDirectory();

        if (file_exists($fileTargetDirectory)) {
            return Errors::UNEXPECTED_ERROR;
        }

        if(!in_array(strtolower($this->extension), self::IMAGE_EXTENSIONS) &&
           !in_array(strtolower($this->extension), self::VIDEO_EXTENSIONS)) {
            return Errors::WRONG_FILE_FORMAT;
        }

        if ($this->file["size"] > $this->maxFileSize) {
            return Errors::FILE_TOO_LARGE;
        }

        if (move_uploaded_file($this->file["tmp_name"], $fileTargetDirectory)) {
            return $fileTargetDirectory;
        } else {
            return Errors::FILE_NOT_UPLOADED;
        }
    }

    private function getDirectory(): string {
        $randomString = FileUpload::getRandomString();
        $directoryToUpload = "";
        if ($this->contentName == null) {
            $directoryToUpload = $this->baseDirectory->value . $this->userLogin . "/";
        } else {
            $directoryToUpload = $this->baseDirectory->value . $this->userLogin . "/" . $this->contentName . "/";
        }

        if (!is_dir($directoryToUpload) && !mkdir($directoryToUpload)){
            die("Nepodarilo sa vytvoriť súbor: $directoryToUpload");
        }

        return $directoryToUpload . strtotime("now") . "_" . $randomString . "." . $this->extension;
    }

    private function getRandomString() {
        return substr(
            str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 5)
            ), 0, 5);
    }

    private function getExtension(): string {
        return pathinfo($this->file["name"],PATHINFO_EXTENSION);
    }

    private function maxFileSize(FileType $fileType): void {
        switch ($fileType) {
            case FileType::THUMBNAIL:
                $this->maxFileSize = self::MAX_THUMBNAIL_SIZE;
                break;
            case FileType::PROFILE_PICTURE:
                $this->maxFileSize = self::MAX_PROFILE_PICTURE_SIZE;
                break;
            case FileType::VIDEO:
                $this->maxFileSize = self::MAX_CONTENT_SIZE;
                break;
        }
    }
}