<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

/**
 * Check if the input is ends with specified string
 * 
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class EndsWith extends AbstractValidator
{
    protected $notFoundMessage = '%name% must end with "%findMe%"';
    
    protected $negativeMessage = '%name% must not end with "%findMe%"';
    
    protected $findMe;
    
    protected $case = false;
    
    public function __invoke($input, $findMe = null, $case = null)
    {
        $findMe && $this->storeOption('findMe', $findMe);
        is_bool($case) && $this->storeOption('case', $case);
        
        return $this->isValid($input);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function validate($input)
    {
        if (!$this->isString($input)) {
            $this->addError('notString');
            return false;
        }

        if (is_string($this->findMe)) {
            $pos = strlen($input) - strlen($this->findMe);
            $fn = $this->case ? 'strrpos' : 'strripos';
            if ($pos !== $fn($input, $this->findMe)) {
                $this->addError('notFound');
                return false;
            }
        } elseif (is_array($this->findMe)) {
            $pattern = '/' . implode('|', $this->findMe) . '$/';
            if (!$this->case) {
                $pattern = $pattern . 'i';
            }
            if (!preg_match($pattern, $input)) {
                $this->addError('notFound');
                return false;
            }
        }

        return true;
    }
}
