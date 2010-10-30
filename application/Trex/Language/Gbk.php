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
 * @since       2010-10-22 9:34:55
 */

class Trex_Language_Gbk extends Trex_Language
{
    public function __construct()
    {
		$this->_data += array(
            '' => 'NULL',
            'LBL_QWIN' => 'Qwin',
            'LBL_QWIN_VERSION' => '',
            'LBL_ACTION_LIST' => '�б�',
            'LBL_ACTION_ADD' => '���',
            'LBL_ACTION_EDIT' => '�༭',
            'LBL_ACTION_DELETE' => 'ɾ��',
            'LBL_ACTION_View' => '�鿴',
            'LBL_ACTION_COPY' => '����',
            'LBL_ACTION_FILTER' => 'ɸѡ',
            'LBL_ACTION_RETURN' => '����',
            'LBL_ACTION_RESET' => '����',
            'LBL_ACTION_SUBMIT' => '�ύ',
            'LBL_ACTION_APPLY' => 'Ӧ��',
            'LBL_ACTION_RESTORE' => '��ԭ',
            'LBL_ACTION_REDIRECT' => '��ת',
            'LBL_DEFAULT' => 'Ĭ��',
            'LBL_OPERATION' => '����',
            'LBL_SWITCH_DISPLAY_MODEL' => '�л���ʾģʽ',
            'LBL_SHORTCUT' => '��ݷ�ʽ',
            'LBL_STYLE' => '���',
            'LBL_THEME' => '����',
            'LBL_WELCOME' => '��ӭ��',
            'LBL_LOGOUT' => 'ע��',
            'LBL_TOOL' => '����',
            'LBL_LANG' => '����',
            'LBL_FIELD_ID' => '���',
            'LBL_FIELD_NAME' => '����',
            'LBL_FIELD_NAMESPACE' => '�����ռ�',
            'LBL_FIELD_TITLE' => '����',
            'LBL_FIELD_OPERATION' => '����',
            'LBL_FIELD_DATE_CREATED' => '����ʱ��',
            'LBL_FIELD_DATE_MODIFIED' => '�޸�ʱ��',
            'LBL_FIELD_CAPTCHA' => '��֤��',
            'LBL_FIELD_DESCRIPTION' => '����',
            'LBL_FIELD_CONTENT' => '����',
            'MSG_CHOOSE_ONLY_ONE_ROW' => '��ֻѡ��һ��!',
            'MSG_CHOOSE_AT_LEASE_ONE_ROW' => '��ѡ������һ��!',
            'MSG_CONFIRM_TO_DELETE' => 'ɾ�����޷���ԭ,ȷ��?',
            'MSG_ERROR_FIELD' => '������: ',
            'MSG_ERROR_MSG' => '������Ϣ: ',
            'MSG_NO_RECORD' => '�ü�¼�����ڻ��Ѿ���ɾ��.',
            'MSG_RECORD_EXISTS' => '�ü�¼�Ѵ���',
            'MSG_ERROR_CAPTCHA' => '��֤�����',
            'LBL_GROUP_BASIC_DATA' => '��������',
            'LBL_HTML_TITLE' => 'Management System - Powered by Qwin Framework',
            'LBL_FOOTER_COPYRIGHT' => 'Powered by Qwin Framework. Copyright &copy; 2008-2010 Twin. All rights reserved.',
            'LBL_ACTION_VIEW' => '�鿴',
            'LBL_ACTION_UPDATE' => '����',
            'LBL_LAST_VIEWED' => '����鿴',
            'LBL_MESSAGE' => '��ʾ��Ϣ',
            'LBL_MEMBER_CENTER' => '�û�����',
            'LBL_MANAGEMENT' => '����',
            'LBL_FIELD_CATEGORY_ID' => '������',
            'LBL_FIELD_CATEGORY_NAME' => '��������',
            'LBL_FIELD_CREATOR' => '������',
            'LBL_FIELD_MODIFIER' => '�޸���',
            'LBL_FIELD_CREATED_BY' => '������',
            'LBL_FIELD_MODIFIED_BY' => '�޸���',
            'LBL_FIELD_SUMMARY' => '��Ҫ',
            'LBL_FIELD_TYPE' => '����',
            'LBL_FIELD_PARENT_NAME' => '������',
            'LBL_FIELD_PARENT_ID' => '�����',
            'LBL_FIELD_VALUE' => 'ֵ',
            'LBL_GROUP_DETAIL_DATA' => '��ϸ����',
            'LBL_GROUP_DEFAULT_DATA' => 'Ĭ������',
            'MSG_OPERATE_SUCCESSFULLY' => '�����ɹ�!',
			'MSG_SEARCH_SUCCESSFULLY' => '��ѯ�ɹ�,���ڽ���ת�����ҳ��!',
            'MSG_FUNCTION_DEVELOPTING' => '�������ڿ�����.',
            'MSG_CLICK_TO_REDIRECT' => '3�����ת���µ�ҳ��,���"��ת"��ťֱ����ת.',
            'MSG_NOT_ALLOW_DELETE' => '������ɾ�����û�.',
            'MSG_FILE_NOT_EXISTS' => '�ļ�������',
            'MSG_PERMISSION_NOT_ENOUGH' => '������Ȩ�޲鿴�������ҳ��.',
            'LBL_FIELD_CONTACT_ID' => '��ϵ�˱��',
            'LBL_FIELD_FIRST_NAME' => '����',
            'LBL_FIELD_LAST_NAME' => '��',
            'LBL_FIELD_NICKNAME' => '�ǳ�',
            'LBL_FIELD_PHOTO' => '��Ƭ',
            'LBL_FIELD_RELATION' => '��ϵ',
            'LBL_FIELD_BIRTHDAY' => '����',
            'LBL_FIELD_EMAIL' => '�ʼ�',
            'LBL_FIELD_TELEPHONE' => '�绰',
            'LBL_FIELD_MOBILE' => '�ֻ�',
            'LBL_FIELD_SEX' => '�Ա�',
            'LBL_FIELD_HOMEPAGE' => '��ҳ',
            'LBL_FIELD_ADDRESS' => '��ַ',
            'LBL_FIELD_RELATED_MODULE' => '���ģ��',
            'LBL_FIELD_ORDER' => '˳��',
            
            'MSG_VALIDATOR_REQUIRED' => '�����Ǳ����.',
            'MSG_VALIDATOR_REMOTE' => '�����������ֵ.',
            'MSG_VALIDATOR_EMAIL' => '������Ϸ�������.',
            'MSG_VALIDATOR_URL' => '������Ϸ��ĵ�ַ.',
            'MSG_VALIDATOR_DATE' => '������Ϸ�������.',
            'MSG_VALIDATOR_DATEISO' => '������Ϸ�������(ISO).',
            'MSG_VALIDATOR_NUMBER' => '������Ϸ�������.',
            'MSG_VALIDATOR_DIGITS' => '��ֻ��������.',
            'MSG_VALIDATOR_CREDITCARD' => '��������Ч�����ÿ���.',
            'MSG_VALIDATOR_EQUALTO' => '���ٴ�������ͬ��ֵ.',
            'MSG_VALIDATOR_ACCEPT' => '������Ϸ��ĺ�׺��.',
            'MSG_VALIDATOR_MAXLENGTH' => '�����볤������� {0} ���ַ���.',
            'MSG_VALIDATOR_MINLENGTH' => '�����볤�������� {0} ���ַ���.',
            'MSG_VALIDATOR_RANGELENGTH' => '�����볤���� {0} �� {1} ֮����ַ���.',
            'MSG_VALIDATOR_BYTERANGELENGTH' => '�����볤���� {0} �� {1} ֮����ַ���.',
            'MSG_VALIDATOR_NONNEGATIVEINTEGER' => '������Ǹ�������',
            'MSG_VALIDATOR_RANGE' => '�������� {0} �� {1} ֮���ֵ.',
            'MSG_VALIDATOR_MAX' => '������С�ڻ���� {0} ��ֵ.',
            'MSG_VALIDATOR_MIN' => '��������ڻ���� {0} ��ֵ.',
            'MSG_VALIDATOR_PATHNAME' => '������Ϸ���·������,������ \\/:*?\\"<>| .',
            'MSG_VALIDATOR_NOTNULL' => '�����Ǳ����.',
			'MSG_VALIDATOR_INTEGER' => '����������.',
            'LBL_FORM_VALUE_ADVICE' => '����ֵ����',
            'LBL_FIELD' => '��',
            'LBL_VALUE' => 'ֵ',
            'LBL_TYPE' => '����',
            'LBL_TYPE_NOT_IN' => '������',

            'LBL_SELECTED' => '��ѡ��',
            'LBL_NOT_SELECTED' => 'δѡ��',
            'LBL_READONLY' => 'ֻ��',
            'LBL_PERSONAL' => '����',
            'LBL_LOGIN' => '��¼',
			
			'LBL_LANG_GBK' => '��������(Zh-cn,Gbk)',
			'LBL_LANG_ZHCN' => '��������(Zh-cn,Utf-8)',
			'LBL_LANG_ENUS' => 'Ӣ��(En-us)',
			
			'LBL_CANCEL' => 'ȡ��',
			'LBL_CUSTOM_VALUE' => '�Զ���ֵ',
			
			'LBL_TREE_PREFIX_1' => '��',
			'LBL_TREE_PREFIX_2' => '��',
        );
    }
}