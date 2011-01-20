<?php
/**
 * Zhcn
 *
 * Copyright (c) 2008-2010 Twin Huang. All rights reserved.
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
 * @package     Common
 * @subpackage  Option
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-26 17:20:56
 */

class Common_Option_Language_Zhcn extends Common_Language_Zhcn
{
    public function __construct()
    {
        parent::__construct();
        $this->_data += array(
            'LBL_FIELD_CODE' => '代码',
            'LBL_FIELD_VALUE' => '值',
            'LBL_FIELD_VAR_NAME' => '变量名称',
            'LBL_FIELD_TYPE' => '类型',

            'LBL_OPTION_EDITOR_VALUE' => '值',
            'LBL_OPTION_EDITOR_NAME' => '名称',
            'LBL_OPTION_EDITOR_COLOR' => '颜色',
            'LBL_OPTION_EDITOR_STYLE' => '附加Css样式',
            'LBL_OPTION_EDITOR_OPER' => '操作',
            'LBL_OPTION_EDITOR_ADD' => '添加选项',

            'LBL_ACTION_ADD_NEXT' => '添加下一个分类',

            'LBL_MODULE_OPTION' => '选项',
            'LBL_FIELD_LANGUAGE' => '语言',
            'LBL_FIELD_SIGN' => '标识',

        );
    }
}
