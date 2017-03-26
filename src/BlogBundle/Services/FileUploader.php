<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 08/03/2017
 * Time: 13:21
 */

namespace BlogBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(File $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $fileName);
        return $fileName;
    }

    /**
     * @return mixed
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function testFile($directory,Projet $projet){

        if ($projet->getImageURL() !== '' && null !== ($projet->getImageURL())) {

            $testFile = $directory . '/' . $projet->getImageURL();
            if (file_exists($testFile)) {
                $projet->setImage($projet->getImageURL());
                $projet->setImageURL(
                    new File($testFile));
            } else {
                $projet->setImageURL('');
            }
        } elseif(null == ($projet->getImageURL())) {
            $projet->setImageURL('');
            }

        return $projet;

    }
}