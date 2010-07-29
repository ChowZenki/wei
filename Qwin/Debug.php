<?php
/**
 * qdebug 的名称
 *
 * qdebug 的简要介绍
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
 * @version   2009-10-31 01:19:05 utf-8 中文
 * @since     2009-11-24 20:45:11 utf-8 中文
 */

class Qwin_Debug
{
    function p($a)
    {
        print_r($a);
    }
    
    function e($data = '', $is_exit = true)
    {
        if(is_array($data) || is_object($data))
        {
            print_r($data);
        } else {
            echo $data;
        }
        $is_exit == true && exit();
    }
}
