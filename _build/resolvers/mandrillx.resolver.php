<?php
/**
 * Resolver for MandrillX extra
 *
 * Copyright 2013 by Bob Ray <http://bobsguides.com>
 * Created on 02-05-2014
 *
 * MandrillX is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * MandrillX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MandrillX; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * @package mandrillx
 * @subpackage build
 */

/* @var $object xPDOObject */
/* @var $modx modX */

/* @var array $options */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            /* Set mandrill_api_key System Setting from user input form */
            $value = null;
            $setting = $modx->getObject('modSystemSetting', array('key' => 'mandrill_api_key'));
            if ($setting) {
                $value = $setting->get('value');
            }
            $api_key = isset($options['api_key'])? $options['api_key'] : '' ;
            if ( $setting && (!empty($api_key)) && empty($value)) {
                $setting->set('value', $api_key);
                $setting->save();
            } else {

            }
            break;
        case xPDOTransport::ACTION_UPGRADE:
            /* [[+code]] */
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;