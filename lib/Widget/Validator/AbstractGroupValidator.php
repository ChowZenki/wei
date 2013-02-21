<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget\Validator;

abstract class AbstractGroupValidator extends AbstractValidator
{
    /**
     * The invalid validators
     * 
     * @var array<\Widget\Validator\AbstractValidator>
     */
    protected $validators = array();
    
    /**
     * Whether combine messages into single one or not
     * 
     * @var bool
     */
    protected $combineMessages = true;
    
    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        /**
         * Combines messages into single one
         * 
         * FROM 
         * array(
         *   'atLeast'          => 'atLeast message',
         *   'validator.rule'   => 'first message',
         *   'validator.rul2'   => 'second message',
         *   'validator2.rule'  => 'third message'
         * )
         * TO
         * array(
         *   'atLeast' => "atLeast message\n"
         *              . "first message;second message\n"
         *              . "third message"
         * )
         */
        if ($this->combineMessages) {
            $messages = parent::getMessages();
            $key = key($messages);
        
            foreach ($this->validators as $rule => $validator) {
                $messages[$rule] = implode(';', $validator->getMessages());
            }

            return array(
                $key => implode("\n", $messages)
            );
        } else {
            $messages = array();
            foreach ($this->validators as $rule => $validator) {
                foreach ($validator->getMessages() as $option => $message) {
                    $messages[$rule . '.' . $option] = $message;
                }
            }
            return $messages;
        }
    }
}