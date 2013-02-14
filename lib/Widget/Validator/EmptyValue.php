<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class EmptyValue extends AbstractValidator
{
    protected $emptyMessage = '%name% must be empty';
    
    public function __invoke($input)
    {
        if (!empty($input)) {
            $this->addError('empty');
            return false;
        }
        
        return true;
    }
}
