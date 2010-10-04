<?php
/**
 * FileTree
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
 * @subpackage  Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-19 14:03:50
 */

class Qwin_Widget_JQuery_FileTree
{
    public function __construct()
    {

    }

    /**
     * 生成文件树
     *
     * @param array $meta 域的元数据
     * @return string 文件树代码
     */
    public function render($meta)
    {
        $jquery = Qwin::run('Qwin_Resource_JQuery');
        $buttonId = 'ui-button-filetree-' . $meta['name'];

        $ajaxButtonId = 'ui-button-ajaxupload-' . $meta['name'];

        $code = $jquery->loadUi('position')
            . $jquery->loadUi('dialog')
            . $jquery->loadPlugin('qfiletree')
            . '<button id="' . $buttonId . '" type="button"><span class="ui-icon ui-icon-image">' . $meta['name'] . '</span></button>
              <script type="text/javascript">jQuery(function($){
                $("#' . $buttonId . '").QFileTree({
                    input : "#' . $meta['name'] . '",
                    filetree : {
                        dblClickFolder : function(path){
                            $("#qfiletree_dialog").dialog("close");
                            $("#' . $ajaxButtonId . '").ajaxUpload({
                                input : "#' . $meta['name'] . '",
                                path : path
                            });
                            $("#' . $ajaxButtonId . '").click();
                        }
                    }
                })});
              </script>';
        return $code;
    }
}
