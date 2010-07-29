<?php
/**
 * controller 的名称
 *
 * controller 的简要介绍
 *
 * Copyright (c) 2009 Twin. All rights reserved.
 *
 * LICENSE:
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Twin Huang <twinh@yahoo.cn>
 * @copyright Twin Huang
 * @license   http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @version   2009-11-01 23:20:01 utf-8 中文
 * @since     2009-11-24 20:45:11 utf-8 中文
 */

class Qwin_Miku_Controller
{
    /**
     * 行为重置时,用于保存原来行为的名称
     * @var string
     */
    private $_prev_action;

    /**
     * 模型对象
     * @var object
     */
    public $model;

    /**
     * 元数据对象
     * @var object
     */
    public $meta;

    /**
     * 加载 404 页面失败时见执行此方法
     *
     * @todo rename to actionError ?
     */
    function __error()
    {
        echo 'Cannot find the 404 page in the namespace "' . $this->__query['namespace'] . '"!';
    }

    /**
     * 转换 action
     *
     * @param string $new_action 新的行为名称
     * @return null
     */
    public function setAction($new_action)
    {
        $this->_prev_action = $this->__query['action'];
        $this->__query['action'] = $new_action;
        return $this;
    }

    /**
     * 恢复 action
     *
     * @return string Action 的名称
     */
    public function resetAction()
    {
        $this->__query['action'] = $this->_prev_action;
        return $this;
    }
    
    /**
     * 加载视图
     *
     * @param array $set 视图的nca数组 $set = array('namespace', 'controller' 'action')
     * @param bool/array $is_extract 如果是布尔型,且为真,则导出数组$this->__view;如果是数字,则导出自己
     * @param string
     * @todo layout & element 的实现,模板的扩展
     */
    function loadView($set)
    {
        // 构造文件路径
        if(is_array($set))
        {
            // 兼容两种模式
            if(isset($set['namespace']))
            {
                $set_tmp = array(
                    0 => $set['namespace'],
                    1 => $set['controller'],
                    2 => $set['action'],
                );
                $set = $set_tmp;
            }
            for($i = 0; $i <= 2; $i++)
            {
                !isset($set[$i]) && $set[$i] = 'Default';
            }
            // 加载视图
            //NULL == $controller && $controller = $this;
            $__view_file = ROOT_PATH . DS .'app' . DS . $set[0] . DS . 'View'
                       . DS . $set[1] . DS . $set[2] . '.php';
        } elseif($this->Qwin_Helper_File->isExist($set)){
            $__view_file = $set;
        }
        // 加载文件,并销毁多余变量
        //if(Qwin_Class::run('-file')->isExist($__view_file))
        if(file_exists($__view_file))
        {
            unset($set, $set_tmp, $i);
            @extract($this->__view, EXTR_OVERWRITE);
            require_once $__view_file;
        }
        //return $this;
    }

    public function loadViewElement($code)
    {
        if(!isset($this->__view_element[$code]))
        {
            require_once 'Qwin/Miku/Controller/Exception.php';
            throw new Qwin_Miku_Controller_Exception('The view element "' .  $code . '" isn\'t setted.');
        }
        return $this->__view_element[$code];
    }

    /**
     * 执行 on 方法
     * 
     * @param string $method
     */
    public function executeOnFunction($method)
    {
        if(method_exists($this, 'on' . $method))
        {
            $args = func_get_args();
            array_shift($args);
            call_user_func_array(array($this, 'on' . $method), $args);
        }
    }

    /**
     * 翻译单独一个代号
     * @param string $code 要翻译的代号
     * @return string 如果存在该代号,返回翻译值,否则返回原代号
     * TODO 是否应该放在控制器中
     */
    public function t($code)
    {
        //!isset($this->lang) && $this->lang = Qwin_Class::run('-c')->lang;
        if(isset($this->lang[$code]))
        {
            return $this->lang[$code];
        }
        return $code;
    }

    public function _()
    {
        
    }

    /**
     * 快速初始一个类
     * @param <type> $name
     * @return <type>
     */
    public function __get($name)
    {
        if('Qwin_' == substr($name, 0, 5))
        {
            return Qwin_Class::run($name);
        }
        return null;
    }
}
