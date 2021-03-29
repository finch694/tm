<?php


namespace common\components\storage;


use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Storage extends Component implements StorageInterface
{
    private $fileName;

    /**
     * Save given UploadedFile instance to disk
     * @param UploadedFile $file
     * @return string|null
     */
    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        }
    }

    /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string|null
     */
    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);

        $path = $this->getStoragePath() . $this->fileName;

        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function getFilename(UploadedFile $file)
    {
        $hash = sha1_file($file->tempName);
        $name = $hash . time();
        if ($file->extension !== '') {
            $name .= '.' . $file->extension;
        }
        return $name;
    }

    /**
     * @return string
     */
    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    /**
     *
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

    public function getImgPreview(string $filename)
    {
        if (!preg_match("/\.(jpe?g|gif|png|tiff)$/i", $filename)) {
            $filename = 'template.png';
        }
        return $this->getFile($filename);
    }

    public function deleteFile(string $filename)
    {
        return unlink($this->getStoragePath() . $filename);
    }

    public function getFileLocation(string $filename)
    {
        return $this->getStoragePath() . $filename;
    }
}