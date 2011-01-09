<?php
/**
 * ListTab
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
 * @since       2011-01-04 19:57:49
 */

class Common_Email_Widget_ListTab extends Common_Widget
{
    public function render($param, $view)
    {
        $asc = $view['asc'];
        $url = Qwin::run('-url');
        $lang = Qwin::run('-lang');

        $param['tab'][] = array(
            'url' => $url->createUrl($asc, array('action' => 'Post')),
            'title' => $lang->t('LBL_ACTION_POST'),
            'icon' => 'ui-icon-script',
            'target' => null,
            'id' => null,
            'class' => null,
        );
        $param['object']->renderTab($param['tab'], $view);
    }
}