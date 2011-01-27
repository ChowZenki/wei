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
 * @since       2010-10-22 9:43:51
 */

class Common_Member_Language_Gbk extends Common_Language_Gbk
{
    public function __construct()
    {
        parent::__construct();
        $this->_data += array(
            'LBL_FIELD_USERNAME' => '�û���',
            'LBL_FIELD_PASSWORD' => '����',
            'LBL_FIELD_EMAIL' => '����',
            'LBL_FIELD_NICKNAME' => '�ǳ�',
            'LBL_FIELD_SEX' => '�Ա�',
            'LBL_FIELD_REG_TIME' => 'ע��ʱ��',
            'LBL_FIELD_REG_IP' => 'ע��Ip',
            'LBL_FIELD_EMAIL_FOREIGN_ID' => '����������',
            'LBL_FIELD_EMAIL_ADDRESS' => '�����ַ',
            'LBL_FIELD_EMAIL_REMARK' => '���䱸ע',
            'LBL_FIELD_THEME_NAME' => '�������',
            'LBL_FIELD_LANG' => '���Դ���',
            'LBL_FIELD_GROUP_ID' => '����',
            'LBL_FIELD_NEW_PASSWORD' => '������',
            'LBL_FIELD_OLD_PASSWORD' => '������',
            'LBL_FIELD_CONFIRM_PASSWORD' => 'ȷ������',

            'LBL_FIELD_COMPANY' => '��˾ȫ��',
            'LBL_FIELD_CUSTOMER_NAME' => '�ͻ�����',
            'LBL_FIELD_AREA' => '�ͻ�����',
            'LBL_FIELD_DEPARTMENT' => '�ͻ����ڲ���',
            'LBL_FIELD_POSITION' => '�ͻ�ְ��',
            'LBL_FIELD_TELEPHONE' => '�绰',
            'LBL_FIELD_FAX' => '����',

            'LBL_GROUP_BASIC_DATA' => '��������',
            'LBL_GROUP_DETAIL_DATA' => '��ϸ����',
            'LBL_GROUP_EMAIL_DATA' => '��������',
            'LBL_GROUP_COMPANY_DATA' => '��˾����',

            'LBL_MODULE_MEMBER' => '�û�',
            'LBL_MODULE_MEMBER_DETAIL' => '�û���ϸ',

            'LBL_THEME' => '����',
            'LBL_LANGUAGE' => '����',

            'LBL_APPLY_TO_SETTING' => 'Ӧ�õ�ǰ��񵽸���������',
            'LBL_LOGIN_TITLE' => '��ӭ��ʹ�ñ�ϵͳ',
            'MSG_ERROR_USERNAME_PASSWORD' => '�û������������',
            'MSG_LOGINED' => '���Ѿ���½',
            'MSG_NOT_LOGIN' => '����δ��½',
            'MSG_USERNAME_EXISTS' => '�û����Ѵ���.',


            'MSG_OLD_PASSWORD_NOT_CORRECT' => '�����벻��ȷ',
            'MSG_MEMBER_NOT_ALLOW_DELETE' => '������ɾ��ϵͳ�û�',
            'MSG_GUEST_NOT_ALLOW_EDIT_PASSWORD' => '�������޸��ο�����',

            'LBL_FIELD_IMAGE_PATH' => 'ͼ��·��',
            'LBL_FIELD_QQ' => 'QQ',
            'LBL_FIELD_POSTCODE' => '�ʱ�',
            'LBL_FIELD_MEMBER_ID' => '�û����',
            'LBL_FIELD_THEME' => '����',
            'LBL_FIELD_LANGUAGE' => '����',
            'LBL_FIELD_IP' => 'Ip',
            'LBL_MODULE_MEMBER_GROUP' => '�û���',
            'LBL_MODULE_MEMBER_LOGINLOG' => '�û���½��¼',
            'LBL_VIEW_DATA' => '�鿴��������',
            'LBL_EDIT_DATA' => '�༭��������',
            'LBL_EDIT_PASSWORD' => '�޸�����',
            'LBL_SWITCH_STYLE' => '�л����',
            'LBL_SWITCH_LANGUAGE' => '�л�����',
            'LBL_ACTION_ALLOCATE_PERMISSION' => '����Ȩ��',
            'LBL_ACTION_EDIT_PASSWORD' => '�޸�����',
            'MSG_LOGOUTED' => '���ѵǳ�.',
            'LBL_LOGIN' => '��¼',
        );
    }
}
