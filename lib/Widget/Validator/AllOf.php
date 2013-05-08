<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Widget\Validator;

/**
 * Check if the input is valid by all of the rules
 *
 * @author      Twin Huang <twinhuang@qq.com>
 * @property    Is $is The validator manager
 */
class AllOf extends SomeOf
{
    protected $atLeastMessage = '%name% must be passed by all of these rules';
    
    /**
     * Check if the input is valid by all of the rules
     *
     * @param mixed $input The input to be validated
     * @param array $rules An array that the key is validator rule name and the value is validator options
     * @param int|null $atLeast How manay rules should be validated at least
     * @return bool
     */
    public function __invoke($input, array $rules = array(), $atLeast = null)
    {
        $this->atLeast = count($rules ?: $this->rules);

        return parent::__invoke($input, $rules, $atLeast);
    }
}
