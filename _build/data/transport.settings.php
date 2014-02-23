<?php
/**
 * systemSettings transport file for MandrillX extra
 *
 * Copyright 2013-2014 by Bob Ray <http://bobsguides.com>
 * Created on 02-04-2014
 *
 * @package mandrillx
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'mandrill_api_key',
  'value' => '',
  'xtype' => 'textfield',
  'namespace' => 'mandrillx',
  'area' => '',
  'name' => 'Mandrill API Key',
  'description' => 'Your API key from mandrilapp.com',
), '', true, true);
return $systemSettings;
