<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Dir extends AbstractRule
{
    protected $message = 'This value must be an existing directory';
    
    /**
     * Returns file path or true
     * 
     * @var bool 
     */
    protected $abs = true;
    
    /**
     * Determine the object source is a file path, check with the include_path.
     *
     * @param  bool        $abs return file path or true
     * @return string|bool
     */
    public function __invoke($value)
    {
        if (!is_string($value)) {
            return false;
        }

        // check directly if it's absolute path
        if ('/' == $value[0] || '\\' == $value[0] || ':' == $value[1]) {
            if (is_dir($value)) {
                return $this->abs ? $value : true;
            }
        }

        $full = stream_resolve_include_path($value);
        if ($full) {
            return $this->abs ? $full : true;
        }

        return false;
    }
}
