<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * Check if the input is valid QQ number
 * 
 * @author      Twin Huang <twinhuang@qq.com>
 */
class QQ extends Regex
{
    protected $patternMessage = '%name% must be valid QQ number';
    
    protected $negativeMessage = '%name% must not be valid QQ number';
    
    protected $pattern = '/^[1-9][\d]{4,9}$/';
}
