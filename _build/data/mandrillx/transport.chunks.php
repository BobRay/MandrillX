<?php
/**
 * chunks transport file for MandrillX extra
 *
 * Copyright 2013-2014 by Bob Ray <http://bobsguides.com>
 * Created on 02-05-2014
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
/* @var xPDOObject[] $chunks */


$chunks = array();

$chunks[1] = $modx->newObject('modChunk');
$chunks[1]->fromArray(array (
  'id' => 1,
  'property_preprocess' => false,
  'name' => 'MandrillExampleTpl',
  'description' => '',
), '', true, true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/elements/chunks/mandrillexampletpl.chunk.html'));


$properties = include $sources['data'].'properties/properties.mandrillexampletpl.chunk.php';
$chunks[1]->setProperties($properties);
unset($properties);

return $chunks;
