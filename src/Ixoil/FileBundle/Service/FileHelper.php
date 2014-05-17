<?php

namespace Ixoil\FileBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ixoil\FileBundle\Model\FileType;
use Exception;

/**
 * Description of Uploader
 *
 * @author OXIND
 */
class FileHelper
{
    /**
     *
     * @var string
     */
    protected $dataPath;
    
    /**
     *
     * @var type 
     */
    protected $kernel;

    /**
     *
     * @param string $basePath
     */
    public function __construct($kernel, $basePath)
    {
        $this->kernel = $kernel;
        $this->setDataPath($basePath);
    }

    /**
     * @return string
     */
    public function getDataPath()
    {
        return $this->dataPath;
    }

    /**
     * @param string $path
     */
    public function setDataPath($path)
    {
        $this->dataPath = str_replace('\\', '/', $path);
        if(substr($this->dataPath, -1) != '/')
            $this->dataPath .= '/';
    }

    /**
     * Moves an uploaded file into a specified folder type
     *
     * @param UploadedFile $objFile Uploaded file
     * @param FileType $type Target filetype
     * @param string $fileName Target filename
     */
    public function moveUploaded(UploadedFile $objFile, FileType $type, $fileName)
    {
        $filePath = $this->getFilePath($type, true);

        $objFile->move($filePath, $fileName);
    }

    /**
     *
     * @param FileType $type
     * @param string $fileName
     * @param FileType $newType
     * @param string|null $newName
     * @return bool
     * @throws \Exception
     */
    public function copy(FileType $type, $fileName, FileType $newType, $newName = null)
    {
        if(!$this->exists($type, $fileName))
            throw new Exception(sprint("Can't copy unexisting file \"%s\"", $fileName));

        if($newName === null)
            $newName = $fileName;

        // Get paths
        $filePath = $this->getFilePath($type);
        $newFilePath = $this->getFilePath($newType, true);

        return copy($filePath . $fileName, $newFilePath . $newName);
    }

    /**
     * @param FileType $type
     * @param $fileName
     * @return bool
     * @throws \Exception
     */
    public function delete(FileType $type, $fileName)
    {
        if(!$this->exists($type, $fileName))
            throw new Exception(sprint("Can't delete unexisting file \"%s\"", $fileName));

        $filePath = $this->getFilePath($type);
        return unlink($filePath . $fileName);
    }

    /**
     * Checks if the specified file exists in the specified folder type
     * @param FileType $type
     * @param string|null $fileName
     * @return bool
     */
    public function exists(FileType $type, $fileName = null) {
        $filePath = $this->getFilePath($type);

        if (!file_exists($filePath))
            return false;
        
        if ($fileName != null && !file_exists($filePath . $fileName))
            return false;
        
        return true;
    }

    /**
     * Rename the specified file
     * @param FileType $type
     * @param $oldName
     * @param $newName
     * @return string
     * @throws \Exception
     */
    public function rename(FileType $type, $oldName, $newName) {
        // Check if files exists
        if(!$this->exists($type, $oldName))
            throw new Exception(sprintf("Can't rename unexisting file \"%s\"", $oldName));
        if($this->exists($type, $newName))
            throw new Exception(sprintf("Can't rename to an already existing file \"%s\"", $newName));

        // Rename file
        $filePath = $this->getFilePath($type);
        $newPath = $filePath . $newName;
        rename($filePath . $oldName, $newPath);

        return $newPath;
    }

    /**
     * Move an existing file to an other one.
     * @param FileType $type
     * @param string $fileName
     * @param FileType $destType
     * @param string $destName
     * @param bool $overWrite
     * @throws Exception
     */
    public function move(FileType $type, $fileName, FileType $destType, $destName = null, $overWrite = true)
    {
        if(!$this->exists($type, $fileName))
            throw new Exception(sprintf("Can't move unexisting file \"%s\"", $fileName));

        if(!$destName)
            $destName = $fileName;

        // Check if we can override an existing file
        if(!$overWrite && $this->exists($destType, $destName))
            throw new Exception(sprintf("Can't override existing file \"%s\"", $destName));

        // Copy previous file
        $this->copy($type, $fileName, $destType, $destName);

        // Remove previous one
        $this->delete($type, $fileName);
    }
    
    /**
     * Returns the list of files in the specified directory
     * @param \Ixoil\FileBundle\Model\FileType $type
     * @param boolean $absolutePath
     * @return array
     */
    public function scandir(FileType $type, $absolutePath = true)
    {
        // Get path
        $path = $this->getFilePath($type);
        
        // Scandir
        $files = array_diff(scandir($path), array('..', '.'));
        
        // Prepend absolute path if required
        if ($absolutePath) {
            $files = array_map(
                function($value) use ($path) {
                    return $path . $value;
                }, 
                $files
            );
        }
        
        return $files;
    }
    
    /**
     * 
     * @param \Ixoil\FileBundle\File\FileType $type
     * @param bool $mkdir If true, will try to create this file
     * @return string
     * @throws \Exception
     */
    public function getFilePath(FileType $type, $mkdir = false)
    {
        $basepath = '';

        // Get path
        switch($type->getType()) {
            case FileType::Account:
                $value = $type->getValue();
                if (is_object($type->getValue()))
                    $value = $value->getId();
                $basepath = 'accounts' . DIRECTORY_SEPARATOR . $value;
                break;
            
            case FileType::User:
                $value = $type->getValue();
                if (is_object($type->getValue()))
                    $value = $value->getId();
                $basepath = 'users' . DIRECTORY_SEPARATOR . $value;
                break;
            
            case FileType::Tmp:
                $basepath = 'tmp';
                break;
            
            default:
                throw new Exception(sprintf('Invalid file type "%s"', $type->getType()));
        }
        
        // Get folder path
        $path = $this->kernel->getRootDir() . 
                DIRECTORY_SEPARATOR . 
                $this->getDataPath() . 
                $basepath;

        // Create the folder if required
        if($mkdir && (!file_exists($path) || !is_dir($path))) {
            $ret = mkdir($path, 0755, true);
            if(!$ret)
                throw new Exception(sprintf('Could not create directory "%s".', $basepath));
        }

        return $path . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $fileName
     * @param bool $withDot
     * @return string
     */
    public function guessExtension($fileName, $withDot = true)
    {
        $pos = strrpos($fileName, '.', -1);
        return ($pos !== false ?
            strtolower(substr($fileName, $pos + ($withDot ? 0 : 1))) :
            ''
        );
    }

    /**
     * @param $originalFilename The original filename. Used to guess extension
     * @param $seconds How much seconds the file will be valid
     * @return string
     */
    public function getTemporaryName($originalFilename, $seconds = 0)
    {
        // Get file extension (with the dot)
        $ext = $this->guessExtension($originalFilename);

        // Prepare date validation part
        $timestamp = '';
        if($seconds > 0) {
            $date = new \DateTime();
            $date->add(new \DateInterval('PT' . ((int) $seconds) . 'S'));
            $timestamp = '-' . $date->getTimestamp();
        }

        return $this->generateRandomString() . $timestamp . $ext;
    }
    
    
    public function clearTemporaryFiles($type = null)
    {
        if ($type === null)
            $type = FileType::tmp();
        
        // Check if directory exists
        if (!$this->exists($type))
            return array();
        
        // List all files
        $files = $this->scandir($type);
        
        // Check their names to remove temporaries
        $removed = array();
        foreach ($files as $file) {
            $basename = basename($file);
            
            // Check if file is a temporary
            $matches = array();
            if (!preg_match('/-([0-9]{10,})\\.[a-z0-9]+$/i', $basename, $matches))
                continue;
            
            // Extract timestamp
            $date = new \DateTime();
            $date->setTimestamp(intval($matches[1]));
            
            // Compare dates
            $now = new \DateTime();
            if ($now < $date) {
                // Delete file
                $this->delete($type, $basename);
                $removed[] = $file;
            }
        }
        
        return $removed;
    }

    /**
     * Funtion to generate random string
     * @param int $length
     * @return string
     */
    protected function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, strlen($characters) - 1)];

        return $randomString;
    }
}
