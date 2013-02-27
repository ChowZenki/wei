<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

use Widget\Exception\RuntimeException;

/**
 * The default logger for widget, which is base on the Monolog!
 *
 * @author      Twin Huang <twinh@yahoo.cn>
 * @link        https://github.com/Seldaek/monolog
 */
class Logger extends AbstractWidget
{
    /**
     * The name of channel
     *  
     * @var string
     */
    protected $name = 'widget';

    /**
     * The default level for log record which level is not specified
     * 
     * @var string
     */
    protected $level = 'debug';
    
    /**
     * The lowest level to be handled
     * 
     * @var string
     */
    protected $handledLevel = 'debug';
    
    /**
     * The log levels and priorities
     *
     * @var array
     */
    protected $levels = array(
        'debug'     => 0,
        'info'      => 1,
        'notice'    => 2,
        'warning'   => 3,
        'error'     => 4,
        'critical'  => 5,
        'alert'     => 6,
        'emergency' => 7
    );

    /**
     * The format for log message
     * 
     * @var string 
     */
    protected $format = "[%datetime%] %channel%.%level%: %message%\n";
    
    /**
     * The date format for log message
     * 
     * @var string 
     */
    protected $dateFormat = 'Y-m-d H:i:s';
    
    /**
     * The log file name, if specify this parameter, the "dir" and "fileFormat" 
     * parameters would be ignored
     * 
     * @var null|string 
     */
    protected $file = null;
    
    /**
     * The directory to store log files
     * 
     * @var type 
     */
    protected $dir = 'log';
    
    /**
     * The log file name, formatted by date
     * 
     * @var string 
     */
    protected $fileFormat = 'Ymd.\l\o\g';
    
    /**
     * The max file size for log file, default to 128mb, set 0 to ignore this 
     * property
     * 
     * @var int 
     */
    protected $fileSize = 134217728;
    
    /**
     * The log file handle
     * 
     * @var resource|null 
     */
    protected $handle;

    /**
     * Whether log file's exact path has been detected, when set dir, fileFormat
     * or fileSize options, log file should be detected again
     *
     * @var bool
     */
    protected $fileDetected = false;

    /**
     * Logs with an arbitrary level
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return bool Whether the log record has been handled
     */
    public function __invoke($level, $message, array $context = array())
    {
        $level = isset($this->levels[$level]) ? $level : $this->level;

        $record = array(
            'level' => $level,
            'message' => $message,
            'time' => microtime(true),
        );

        // Check if the level would be handle
        if (isset($this->levels[$level])) {
            if ($this->levels[$level] < $this->levels[$this->handledLevel]) {
                return false;
            }
        }

        // Format the log message
        $content = str_replace(array(
            '%datetime%', '%channel%', '%level%', '%message%',
        ), array(
            date($this->dateFormat, $record['time']),
            $this->name,
            strtoupper($record['level']),
            $record['message'],
        ), $this->format);
        
        // Write the log message
        if (!$this->handle) {
            $this->handle = fopen($this->getFile(), 'a');
        }
        fwrite($this->handle, $content);
        
        return true;
    }
    
    /**
     * Logs with an arbitrary level
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function log($level, $message, array $context = array())
    {
        return $this($level, $message, $context);
    }

    /**
     * Get log file
     *
     * @return string
     * @throws Widget\Exception\RuntimeException When unable to create logging directory
     */
    public function getFile()
    {
        if ($this->fileDetected) {
            return $this->file;
        }

        $this->handle = null;
        $file = &$this->file;

        if (!is_dir($this->dir) && false === @mkdir($this->dir, 0777, true)) {
            throw new RuntimeException('Unable to create directory ' . $this->dir);
        }
        
        $file = realpath($this->dir) . '/' . date($this->fileFormat);

        if ($this->fileSize) {
            $firstFile = $file;

            $files = glob($file . '*', GLOB_NOSORT);

            if (1 < count($files)) {
                natsort($files);
                $file = array_pop($files);
            }

            if (is_file($file) && $this->fileSize < filesize($file)) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if (is_numeric($ext)) {
                    $file = $firstFile . '.' . ($ext + 1);
                } else {
                    $file = $firstFile . '.1';
                }
            }
        }

        $this->fileDetected = true;

        return $file;
    }
    
    /**
     * Set default log level
     * 
     * @param string $level
     * @return \Widget\Logger
     */
    public function setLevel($level)
    {
        $this->level = $level;
        
        return $this;
    }
    
    public function setHandledLevel($handledLevel)
    {
        $this->handledLevel = $handledLevel;
        
        return $this;
    }
    
    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function emergency($message, array $context = array())
    {
        return $this('emergency', $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function alert($message, array $context = array())
    {
        return $this('alert', $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function critical($message, array $context = array())
    {
        return $this('critical', $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function error($message, array $context = array())
    {
        return $this('error', $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function warning($message, array $context = array())
    {
        return $this('warning', $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function notice($message, array $context = array())
    {
        return $this('notice', $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function info($message, array $context = array())
    {
        return $this('info', $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function debug($message, array $context = array())
    {
        return $this('debug', $message, $context);
    }

    /**
     * Clear up all log file
     * 
     * @return \Widget\Logger
     */
    public function clean()
    {
        // Make sure the handle is close
        $this->close();
        
        $dir = dirname($this->getFile());
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ('.' != $file && '..' != $file) {
                    $file = $dir . DIRECTORY_SEPARATOR .  $file;
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            }
        }
        return $this;
    }
    
    protected function close()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
        $this->handle = null;
    }
    
    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->close();
    }
}
