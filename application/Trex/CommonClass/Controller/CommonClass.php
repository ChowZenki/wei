<?php
 /**
 * 通用的二级分类
 *
 * 通用二级分类的后台控制器
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
 * @version   2009-11-21 12:18 utf-8 中文
 * @since     2009-11-21 12:18 utf-8 中文
 */

class Trex_CommonClass_Controller_CommonClass extends Trex_Controller
{
    /**
     * 获取指定类型(type_id)的最大值
     */
    public function actionGetMaxCode()
    {
        $type_id = substr(intval($this->_request->g('type_id')), 0, 1);
        $query = $this->meta->getQuery($this->_set);
        $query->select('MAX(code) as max_code')
            ->where('LEFT(code, 1) = ?', $type_id);
        $data = $query->fetchOne()->toArray();
        if($data['max_code'])
        {
            $max_code = substr($data['max_code'], 0, 4);
            $code = $max_code + 1 . '000';
        } else {
            $code = $type_id . '001000';
        }
        echo $code;
    }

    /**
     * on 函数
     */
    public function onAfterDb($action, $data)
    {
        Qwin::run('Project_Helper_CommonClass')->write($data);
    }
    
    /**

    public function convertEditCode($val, $name, $row, $row_copy)
    {
        // 删除"类型"域
        unset($this->__meta['field']['type']);
        $this->__meta['field']['code']['form']['readonly'] = 'readonly';
        if(substr($row_copy['code'], 4) != '000')
        {
            $this->__meta['field']['var_name']['form']['_type'] = 'hidden';
        }
        return $val;
    }

    public function convertEditValue($val)
    {
        $val = @unserialize($val);
        return Qwin::run('-arr')->jsonEncode($val);
    }

    public function convertAddCode($field)
    {
        $code = intval($this->_request->g('code')) ;
        $query = $this->meta->getQuery($this->_set);
        // 添加已有分类的下一个
        if(4 <= strlen($code))
        {
            $category = substr($code, 0, 4);
            $query->select('MAX(code) as max_code')
                ->where('LEFT(code, 4) = ?', $category);
            $data = $query->fetchOne()->toArray();
            // 已存在该分类
            if($data['max_code'])
            {
                // 删除"类型"域
                unset($this->__meta['field']['type']);
                // 删除"变量名称"域,因为"变量名称"只在第一个分类,即作为父分类时需要添加
                unset($this->__meta['field']['var_name']);
                return $data['max_code'] + 1;
            }
        }

        // 添加新的分类
        $query->select('MAX(code) as max_code');
        $data = $query->fetchOne()->toArray();
        if($data['max_code'])
        {
            $max_code = substr($data['max_code'], 0, 4);
            return $max_code + 1 . '000';
        } else {
            return 1001000;
        }
    }*/

    /**
     * db 转换函数
     * @todo 转义还原, map的安全检查,结构应该是二维 stdClass
     */
    public function convertDbValue($val, $name, $row, $row_copy)
    {
        $val = str_replace('\"', '"', $val);
        $data = Qwin::run('-arr')->jsonDecode($val, 'pear');
        return serialize($data);
    }

    /*public function convertListOperation($val, $name, $data, $cpoyData)
    {
        $html = '<a class="ui-state-default ui-jqgrid-icon ui-corner-all" title="' . $this->t('LBL_ACTION_ADD_NEXT') .'" href="' . url(
                array($this->_set['namespace'], $this->_set['module'], $this->_set['controller'], 'Add'),
                array('code' => $cpoyData['code'])
            ) . '"><span class="ui-icon ui-icon-plusthick"></span></a>';
        $html .= $this->meta->getOperationLink($this->__meta['db']['primaryKey'], $data[$this->__meta['db']['primaryKey']], $this->_set);
        return $html;
    }*/
}
