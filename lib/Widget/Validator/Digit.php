<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * Check if the input contains only digits (0-9)
 * 
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Digit extends Regex
{
    protected $patternMessage = '%name% must contain only digits (0-9)';
    
    protected $negativeMessage = '%name% must not contain only digits (0-9)';
    
    protected $pattern = '/^([0-9]+)$/';
}
