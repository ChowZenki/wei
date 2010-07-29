<?php
/**
 * Model
 *
 * Copyright (c) 2009-2010 Twin. All rights reserved.
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
 * @version   2010-7-27 12:37:11
 * @since     2010-7-27 12:37:11
 */

class Qwin_Metadata_Element_Model extends Qwin_Metadata_Element_Abstract
{
    public function getSampleData()
    {
        return array(
            // 模型类名
            'name' => NULL,
            'asName' => NULL,
            // Metadata 中包含模型字段,表名,关系的定义,
            'metadata' => NULL,
            'type' => 'hasOne',
            'local' => 'id',
            'foreign' => NULL,
        );
    }
}
