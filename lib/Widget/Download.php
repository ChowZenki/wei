<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * A widget send file download response
 *
 * @author      Twin Huang <twinhuang@qq.com>
 * @property    Request $request A widget that handles the HTTP request data
 */
class Download extends Response
{
    /**
     * The HTTP content type
     *
     * @var string
     */
    protected $type = 'application/x-download';

    /**
     * The type of disposition, could be "attachment" or "inline"
     *
     * With inline, the browser will try to open file within the browser, while attachment will force it to download
     *
     * @var string
     * @link http://stackoverflow.com/questions/1395151/content-dispositionwhat-are-the-differences-between-inline-and-attachment
     */
    protected $disposition = 'attachment';

    /**
     * The file name to display in download dialog
     * 
     * @var string
     */
    protected $filename;

    /**
     * Send file download response
     */
    public function __invoke($file = null, $options = array())
    {
        return $this->send($file, $options);
    }
    
    /**
     * Send file download response
     * 
     * @param string $file The path of file
     * @param array $options The widget options
     * @return Download
     * @throws Exception\NotFoundException When file not found
     */
    public function send($file = null, $options = array())
    {
        $options && $this->setOption($options);
        
        if (!is_file($file)) {
            throw new Exception\NotFoundException('File not found');
        }

        $name = $this->filename ?: basename($file);

        // For IE
        if (preg_match('/MSIE ([\w.]+)/', $this->request->getServer('HTTP_USER_AGENT'))) {
            $filename = '=' . urlencode($name);
        } else {
            $filename = "*=UTF-8''" . urlencode($name);
        }
        
        $this->header->set(array(
            'Content-Description'       => 'File Transfer',
            'Content-Type'              => $this->type,
            'Content-Disposition'       => $this->disposition . ';filename' . $filename,
            'Content-Transfer-Encoding' => 'binary',
            'Expires'                   => '0',
            'Cache-Control'             => 'must-revalidate',
            'Pragma'                    => 'public',
            'Content-Length'            => filesize($file),
        ));
        
        // Send headers
        parent::send();
        
        // Send file content
        readfile($file);
        
        return $this;
    }
}
