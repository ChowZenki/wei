<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

use Widget\Validator\Image;
use Widget\Validator\File as FileValidator;

/**
 * The widget that handle file upload
 *
 * @author      Twin Huang <twinh@yahoo.cn>
 * @property    \Widget\Post $post The post widget
 * @todo        Add service widget and extend it
 */
class Upload extends Image
{
    /**
     * Seems that the total file size is larger than the max size of post data
     *
     * @link http://php.net/manual/en/ini.core.php#ini.post-max-size
     */
    protected $postSizeMessage = 'Seems that the total file size is larger than the max size of allowed post data, please check the size of your file';

    /**
     * $_FILES do not contain the key "$this->field"
     * 
     * @var string
     */
    protected $noFileMessage = 'No file uploaded';
    
    protected $partialMessage = 'Partial file uploaded, please try again';
    
    protected $noTmpDirMessage = 'No temporary directory';
    
    protected $cantWriteMessage = 'Can\'t write to disk';
    
    protected $extensionMessage = 'File upload stopped by extension';
    
    protected $notUploadedFileMessage = 'No file uploaded';
    
    protected $cantMoveMessage = 'Can not move uploaded file';
    
    /**
     * The name for error message
     * 
     * @var string
     */
    protected $name = 'File';
    
    /**
     * The name defined in the file input, if it's not specified, use the first
     * key in $this->uploadedFiles
     *
     * @var string
     */
    protected $field;
    
    /**
     * The diretory to save file, if not exist, will try to create it
     *
     * @var string
     */
    protected $dir = 'uploads';
    
    /**
     * Custome file name without extension to save
     *
     * @var string
     */
    protected $fileName;
    
    /**
     * Whether check if the upload file is valid image or not
     * 
     * You can spcify any one of the following options to enable image detect
     * * maxWidth
     * * maxHeight
     * * minWidth
     * * minHieght
     * 
     * @var bool
     */
    protected $isImage = false;
    
    /**
     * The uploaded files, equal to $_FILES if not provided. so you can provide
     * a uploaded files array for testing
     * 
     * @var array
     */
    protected $uploadedFiles = array();
    
    /**
     * Whether in unit test mode
     * 
     * @var bool
     */
    protected $unitTest = false;
    
    /**
     * Constructor
     * 
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options + array(
            'dir' => $this->dir
        ));
        
        if (!isset($options['uploadedFiles'])) {
            $this->uploadedFiles = $_FILES;
        }
    }

    /**
     * Upload a file
     * 
     * @param string|array $field
     * @param array $options
     * @return bool
     */
    public function __invoke($field = null, $options = array())
    {
        // ($field, $options)
        if (is_string($field)) {
            $this->field = $field;
            $options && $this->setOption($options);
        // ($options)
        } elseif (is_array($field)) {
            $field && $this->setOption($field);
        }
        
        $uploadedFiles = $this->getUploadedFiles();
        
        // Set default name
        if (!$this->field) {
            $this->field = key($uploadedFiles);
        }
        
        // TODO detail description for this situation
        // Check if has file uploaded or file too large
        if (!isset($uploadedFiles[$this->field])) {
            if (empty($uploadedFiles) && !$this->post->toArray()) {
                $error = 'postSize';
            } else {
                $error = 'noFile';
            }
            $this->addError($error);
            return false;
        }

        $uploadedFile = $uploadedFiles[$this->field];
        
        if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
            switch ($uploadedFile['error']) {
                // File larger than upload_max_filesize
                case UPLOAD_ERR_INI_SIZE :
                    $this->addError('maxSize');
                    break;

                // File larger than MAX_FILE_SIZE defiend in html form
                case UPLOAD_ERR_FORM_SIZE :
                    $this->addError('maxSize');
                    break;

                case UPLOAD_ERR_PARTIAL :
                    $this->addError('partial');
                    break;

                case UPLOAD_ERR_NO_TMP_DIR :
                    $this->addError('noTmpDir');
                    break;

                case UPLOAD_ERR_CANT_WRITE :
                    $this->addError('cantWrite');
                    break;

                case UPLOAD_ERR_EXTENSION :
                    $this->addError('extension');
                    break;

                case UPLOAD_ERR_NO_FILE :
                default :
                    $this->addError('noFile');
            }
            return false;
        }

        if (!$this->isUploadedFile($uploadedFile['tmp_name'])) {
            $this->addError('notUploadedFile');
            return false;
        }
        
        if ($this->isImage || $this->maxWidth || $this->maxHeight || $this->minWidth || $this->minHeight) {
            $result = parent::validate($uploadedFile);
        } else {
            $result = FileValidator::validate($uploadedFile);
        }
        
        if (false === $result) {
            return false;
        }
        
        return $this->saveFile($uploadedFile);
    }

    /**
     * Save uploaded file to upload directory
     * 
     * @param array $uploadedFile
     * @return boolean
     */
    protected function saveFile($uploadedFile)
    {
        if ($this->fileName) {
            $fileName = $this->fileName . '.' . $this->ext; 
        } else {
            $fileName = $uploadedFile['name'];
        }
        
        $this->file = $this->dir . '/' . $fileName;
        if (!$this->moveUploadedFile($uploadedFile['tmp_name'], $this->file)) {
            $this->addError('cantMove');
            $this->logger->critical($this->cantMoveMessage);
            return false;
        }
        
        return true;
    }
    
    /**
     * Returns the uploaded file path
     * 
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
   

    /**
     * Set upload directory
     * 
     * @param string $dir
     * @return \Widget\Upload
     */
    public function setDir($dir)
    {
        $dir = rtrim($dir, '/');
        if (!is_dir($dir)) {
            mkdir($dir, 0700, true);
        }
        $this->dir = $dir;
        
        return $this;
    }
    
    /**
     * Returns upload directory
     * 
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }
    
    /**
     * Get uploaded file list
     *
     * @return array
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
    
    /**
     * Check if the file was uploaded via HTTP POST, if $this->unitTest is 
     * enable, it will always return true
     * 
     * @param string $file
     * @return bool
     */
    protected function isUploadedFile($file)
    {
        return $this->unitTest ? is_file($file) : is_uploaded_file($file);
    }
    
    /**
     * Moves an uploaded file to a new location, if $this->unitTest is enable, 
     * it will use `copy` function instead
     * 
     * @param string $from The uploaded file name
     * @param string $to The destination of the moved file.
     * @return bool
     */
    protected function moveUploadedFile($from, $to)
    {
        return $this->unitTest ? copy($from, $to) : @move_uploaded_file($from, $to);
    }
}
