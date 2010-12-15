<?php
/**
 * Gbk
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
 * @package     Qwin
 * @subpackage  
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-10-22 10:42:54
 */

class Common_Management_Language_Gbk extends Common_Language_Gbk
{
    public function  __construct()
    {
        parent::__construct();
        $this->_data += array(
            'LBL_MODULE_APPLICATION_STRUCTURE' => 'Ӧ��Ŀ¼�ṹ',


            'LBL_FIELD_MODULE' => 'ģ��',

            'LBL_ACTION_UPDATE_APPLICATION_STRUCTURE' => '����Ӧ��Ŀ¼�ṹ�ļ�',
            'LBL_ACTION_ADD_NAMESPACE' => '��������ռ�',
            'LBL_ACTION_NAMESPACE_LIST' => '�����ռ��б�',
            'LBL_ACTION_ADD_MODULE' => '���ģ��',
            'LBL_ACTION_VIEW_MODULE' => '�鿴ģ��',

            'MSG_VALIDATOR_NAMESPACE_EXISTS' => '�����ռ��Ѵ���.',
            'MSG_NAMESAPCE_NOT_EXISTS' => '�����ռ䲻����.',
            'MSG_NAMESPACE_NOT_EMPTY' => '�����ռ��ļ��в�Ϊ��,���ܱ�ɾ��.',
            'MSG_MODULE_EMPTY' => '�������ռ䲻�����κ�ģ��.',
            'MSG_MODULE_EXISTS' => 'ģ���Ѵ���.',

            'LBL_MANAGEMENT' => '����',
            'LBL_NAMESPACE' => '�����ռ�',
            'LBL_MODULE' => 'ģ��',
        );
    }
}
