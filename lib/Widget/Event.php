<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Widget;

use Widget\Event\Event as StdEvent;

/**
 * The event manager to add, remove and trigger events
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Event extends AbstractWidget
{
    /**
     * The array contains the event handlers
     *
     * @var array
     */
    protected $handlers = array();

    /**
     * The available priorities text
     *
     * @var array
     */
    protected $priorities = array(
        'low'       => -1000,
        'normal'    => 0,
        'high'      => 1000
    );

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        $this->registerInternalEvent();
    }

    /**
     * Create a event object
     *
     * @param string $type
     * @return \Widget\Event\Event
     */
    public function __invoke($type)
    {
        list($type, $namespaces) = $this->splitNamespace($type);
        return new StdEvent(array(
            'widget'        => $this->widget,
            'type'          => $type,
            'namespaces'    => $namespaces,
        ));
    }

    /**
     * Trigger an event
     *
     * @param  string $type The name of event or an Event object
     * @param  array $args The arguments pass to the handle
     * @param null|WidgetInterface $widget If the widget contains the
     *                                     $type property, the event manager
     *                                     will trigger it too
     * @return Event\Event The event object
     */
    public function trigger($type, $args = array(), WidgetInterface $widget = null)
    {
        if ($type instanceof StdEvent) {
            $event      = $type;
            $type       = $event->getType();
            $namespaces = $event->getNamespaces();
        } else {
            $event = $this($type);
        }

        if (!is_array($args)) {
            $args = array($args);
        }

        // Prepend the event and widget manager object to the beginning of the arguments
        array_unshift($args, $event, $this->widget);

        if (isset($this->handlers[$type])) {
            krsort($this->handlers[$type]);
            foreach ($this->handlers[$type] as $handlers) {
                foreach ($handlers as $handler) {
                    if (!$namespaces || !$handler[2] || $namespaces == array_intersect($namespaces, $handler[2])) {
                        list($fn, $data) = $handler;
                        $event->setData($data);

                        if (false === ($result = call_user_func_array($fn, $args))) {
                            $event->preventDefault();
                        }
                        $event->setResult($result);

                        if ($event->isPropagationStopped()) {
                            break 2;
                        }
                    }
                }
            }
        }

        if ($widget && $selfEvent = $widget->getOption($type)) {
            if (is_callable($selfEvent)) {
                if (false === ($result = call_user_func_array($selfEvent, $args))) {
                    $event->preventDefault();
                }
                $event->setResult($result);
            }
        }

        return $event;
    }

    /**
     * Attach a handler to an event
     *
     * @param string|array $type The type of event, or an array that the key is event type and the value is event hanlder
     * @param callback $fn The event handler
     * @param int|string $priority The event priority, could be int or specify strings, the higer number, the higer priority
     * @param array $data The data pass to the event object, when the handler is triggered
     * @return EventManager
     */
    public function on($type, $fn = null, $priority = 0, $data = array())
    {
        // ( $types )
        if (is_array($type)) {
            foreach ($type as $name => $fn) {
                $this->on($name, $fn);
            }
            return $this;
        }

        // ( $type, $fn, $priority, $data )
        if (!is_callable($fn)) {
            throw new Exception\UnexpectedTypeException($fn, 'callable');
        }

        $priority = is_numeric($priority) ? $priority :
            (isset($this->priorities[$priority]) ? $this->priorities[$priority] : 0);

        list($type, $namespaces) = $this->splitNamespace($type);

        if (!isset($this->handlers[$type])) {
            $this->handlers[$type] = array();
        }

        $this->handlers[$type][$priority][] = array($fn, $data, $namespaces);

        return $this;
    }

    /**
     * Remove event handlers by specified type
     *
     * @param string $type The type of event
     * @return EventManager
     */
    public function off($type)
    {
        list($type, $namespaces) = $this->splitNamespace($type);

        if ($type && isset($this->handlers[$type])) {
            if (!$namespaces) {
                unset($this->handlers[$type]);
            } else {
                foreach ($this->handlers[$type] as $i => $handlers) {
                    foreach ($handlers as $j => $handler) {
                        if ($namespaces == array_intersect($namespaces, $handler[2])) {
                            unset($this->handlers[$type][$i][$j]);
                        }
                    }
                }
            }
        // Unbind all event in namespace
        } else {
            foreach ($this->handlers as $type => $handlers) {
                $this->off($type . '.' . implode('.', $namespaces));
            }
        }

        return $this;
    }

    /**
     * Check if has the given type of event handlers
     *
     * @param  string $type
     * @return bool
     */
    public function has($type)
    {
        list($type, $namespaces) = $this->splitNamespace($type);

        if (!$namespaces) {
            return isset($this->handlers[$type]);
        } elseif (!$type) {
            foreach ($this->handlers as $type => $handlers) {
                if (true === $this->has($type . '.' . implode('.', $namespaces))) {
                    return true;
                }
            }
            return false;
        } else {
            if (!isset($this->handlers[$type])) {
                return false;
            } else {
                foreach ($this->handlers[$type] as $handlers) {
                    foreach ($handlers as $handler) {
                        if ($namespaces == array_intersect($namespaces, $handler[2])) {
                            return true;
                        }
                    }
                }
                return false;
            }
        }
    }

    /**
     * Create a new event
     *
     * @return Event\Event
     * @param array $namespaces
     * @todo check interface
     */
    public function create($type, $class = 'Widget\Event\Event')
    {
        list($type, $namespaces) = $this->splitNamespace($type);

        return new $class(array(
            'widget'        => $this->widget,
            'type'          => $type,
            'namespaces'    => $namespaces,
        ));
    }

    /**
     * Register the internal event
     */
    protected function registerInternalEvent()
    {
        $event = $this;

        // Attach the widget manager's construct and constructed event
        $this->widget->setOption(array(
            'construct' => function ($name, $full) use($event) {
                $event('construct.' . $name, array($name, $full));
            },
            'constructed' => function($widget, $name, $full) use($event) {
                $event('constructed.' . $name, array($widget, $name, $full));
            }
        ));
    }

    /**
     * Returns the array with two elements, the first one is the event name and
     * the second one is the event namespaces
     *
     * @param string $type
     * @return array<string|array>
     */
    protected function splitNamespace($type)
    {
        if (false === ($pos = strpos($type, '.'))) {
            return array($type, array());
        } else {
            $namespaces = array_unique(array_filter(explode('.', substr($type, $pos))));
            sort($namespaces);
            return array(
                substr($type, 0, $pos),
                $namespaces
            );
        }
    }
}
