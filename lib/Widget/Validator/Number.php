<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Number extends AbstractValidator
{
    protected $notNumberMessage = '%name% must be valid number';
    
    protected $notMessage = '%name% must not be number';
    
    public function __invoke($input)
    {
        return $this->isValid($input);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function validate($input)
    {
        if (!is_numeric($input)) {
            $this->addError('notNumber');
            return false;
        }
        
        return true;
    }
}
