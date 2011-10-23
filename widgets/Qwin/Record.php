<?php
 /**
 * Record
 *
 * Copyright (c) 2008-2011 Twin Huang. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package     Widget
 * @subpackage  Record
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-04-17 15:49:35
 */

class Qwin_Record extends Doctrine_Record
{
    /**
     * 数据库连接标识
     * @var bool
     */
    protected static $_connected = false;
    
    public $invoker;
    
    public $source;
    
    /**
     * @var array $_defaults        默认选项
     *
     *      -- name                 名称
     *
     *      -- title                标题
     *
     *      -- description          域描述
     *
     *      -- order                排序
     *
     *      -- dbField              是否为数据库字段
     *
     *      -- dbQuery              是否允许数据库查询
     *
     *      -- urlQuery             是否允许Url查询
     *
     *      -- readonly             是否只读
     */
    protected $_fieldDefaults = array(
        'name'          => null,
        'title'         => null,
        'description'   => array(),
        'dbField'       => true,
        'dbQuery'       => true,
        'urlQuery'      => true,
        'readonly'      => false,
        // TODO 扩展
        //'type'          => 'string',
        //'length'        => null,
        //'default'       => null,
        //'unsigned'      => false,
        //'notnull'       => false,
        //'primary'       => false,
        //'fixed'         => false,
    );
    
    protected $_relationDefaults = array(
        'module'    => null,
        'alias'     => null,
        'meta'      => 'db',
        'relation'  => 'hasOne',
        'local'     => 'id',
        'foreign'   => 'id',
        'type'      => 'db',
        'fieldMap'  => array(), // ?是否仍需要
        'enabled'   => true,
    );
    
    /**
     * 默认选项
     * @var array
     */
    public $options = array(
        'fields'    => array(),
        //'type'      => 'sql',
        'uid'       => 'db',
        'table'     => null,
        'id'        => 'id',
        'alias'     => null,
        'indexBy'   => null,
        'offset'    => 0,
        'limit'     => 10,
        'order'     => array(),
        'where'     => array(),
        'relations' => array(),
    );
    
    public function __construct($table = null, $isNewEntry = false)
    {
        // 保证连接数据库链接上,否则出现异常
        self::connect();
        $this->getRecordData();
        parent::__construct($table, $isNewEntry);
    }
    
    /**
     * 将数据格式化并加入
     *
     * @param array $data 数据
     * @param array $option 选项
     * @return Qwin_Meta_Field 当前对象
     */
    public function merge2($data, array $options = array())
    {
        $data = (array)$data + $this->_defaults;
        !is_array($data['fields']) && (array)$data['fields'];

        // 处理通配选项
        if (array_key_exists('*', $data['fields'])) {
            $this->_fieldDefaults = $this->_fieldDefaults + (array)$data['fields']['*'];
            unset($data['fields']['*']);
        }

        foreach ($data['fields'] as $name => &$field) {
            !isset($field['name']) && $field['name'] = $name;
            //!isset($field['title']) && $field['title'] = 'FLD_' . strtoupper($name);
            $field = (array)$field + $this->_fieldDefaults;
        }
        
        foreach ($data['relations'] as &$relation) {
            $relation += $this->_relationDefaults;
        }
        
        $this->exchangeArray($data);
        return $this;
    }
    
    /**
     * 获取模块记录
     * 
     * @param string $name 记录名称
     * @param Qwin_Module $module 模块名称
     * @return Qwin_Record 
     */
    public function call($name = null, $module = null)
    {
        $widget = Qwin::getInstance();
        if (!$module) {
            $module = $widget->module();
        }
        $class = $module->toClass() . '_' . ucfirst($name) . 'Record';
        return $widget->call($class);
    }
    
    /**
     * 设置字段属性和关联关系
     *
     * @return void
     */
    public function setTableDefinition()
    {
        $data = $this->options;
        if (empty($data)) {
            return $this;
        }

        // 设置数据表
        $this->setTableName($data['table']);

        // 设置字段
        foreach ($data['fields'] as $name => $field) {
            //if ($field['dbField'] && $field['dbQuery']) {
                $this->hasColumn($name);
            //}
        }

        // 设置关联
        /*foreach ($data['relations'] as  $relation) {
            $class = self::getByModule($relation['module'], $relation['meta'], false);
            call_user_func(
                array($this, $relation['relation']),
                $class . ' as ' . $relation['alias'],
                array(
                    'local' => $relation['local'],
                    'foreign' => $relation['foreign']
                )
            );
        }*/
    }
    
    /**
     * 获取记录配置
     * 
     * @return array
     */
    public function getRecordData()
    {
        return array();
    }

    /**
     * 连接数据库
     *
     * @return void
     * @todo 配置应该更规范
     */
    public static function connect()
    {
        if (!self::$_connected) {
            $manager = Doctrine_Manager::getInstance();
            $db = Qwin::getInstance()->config('database');
            $adapter = $db['type'] . '://'
                     . $db['username'] . ':'
                     . $db['password'] . '@'
                     . $db['server'] . '/'
                     . $db['database'];
            $conn = $manager->openConnection($adapter);

            // 设置字段查询带引号
            $conn->setAttribute(Doctrine_Core::ATTR_QUOTE_IDENTIFIER, true);

            // 设置数据表名称格式
            $manager->setAttribute(Doctrine_Core::ATTR_TBLNAME_FORMAT, $db['prefix'] . '%s');

            // 设置字符集
            $conn->setCharset($db['charset']);
            $conn->setCollate($db['collate']);

            self::$_connected = true;
        }
        return;
    }
}
