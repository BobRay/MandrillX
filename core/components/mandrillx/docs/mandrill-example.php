<?php
/**
 * MandrillX example php file for MandrillX extra
 *
 * Copyright 2013 by Bob Ray <http://bobsguides.com>
 * Created on 02-04-2014
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
 *
 * @package mandrillx
 */

/* This example sends a message about a resource using the
 * MandrillExampleTpl chunk Snippet. Any snippet, setting,
 * and chunk tags in the Tpl chunk as well as any default
 * properties of the chunk will be processed automatically
 * when getChunk() is called.
 *
 * User-specific fields that will be different for each message
 * will be handled as merge variables automatically when sent
 * as an array to the addUser() method. IMPORTANT: They must be
 * in the chunk as placeholders in this style: {{+tagName}}
 *
 * Because getChunk() knows nothing about the resource, we need to
 * set any other fields in an array to be sent as a second argument
 * to getChunk(). They should be in the form of standard MODX
 * placeholders: [[+placeholderName]], these will be the same
 * for each message. In this example, the ID of the page must be
 * included so that the link tags in the Tpl chunk will work.
 *
 * The example also sets placeholders for any of the resource's
 * TVs if they are specified in the $scriptProperties array. There
 * are no TVs in the example Tpl chunk, but you can create the TVs,
 * add tags for them in the chunk, and specify them in the properties
 * to see them set in the message. They must be written in the chunk
 * as placeholders: [[+tvName]]
 * They must also be specified in both the $includeTVs property
 * and the $includeTVList property.
 */


/** @var $modx modX */
/** @var  $scriptProperties array */

/* You will need to create the instantiatemodx.php file in the
 * following location to run this outside of MODX
 * */
if (!defined('MODX_CORE_PATH')) {
    require_once 'c:/xampp/htdocs/addons/assets/mycomponents/instantiatemodx/instantiatemodx.php';
}

require_once $modx->getOption('mandrillx.core.path', NULL, MODX_CORE_PATH) . 'components/mandrillx/model/mandrillx/mandrillx.class.php';
// $corePath = $modx->getOption('mandrillx.core.path', NULL, $modx->getOption('core_path') . 'components/mandrillx/');

if (!isset($scriptProperties)) {
    $scriptProperties = array(
        // 'html'       => $tpl,
        'subaccount' => 'test', /* This subaccount must exist at Mandrillapp.com */
        'subject'    => 'New Update',
        // 'includeTVs' => '1',
        // 'includeTVList' => 'someTvName',
    );
}

$apiKey = $modx->getOption('mandrill_api_key', null, '');

/* This needs to be the ID of a real resource */
$docId = 38;
$doc = $modx->getObject('modResource', $docId);
if (! $doc) {
    die ('No Document');
}

$fields = $doc->toArray();

$fields['url'] = $modx->makeUrl($docId, "", "", "full");

$includeTVs = $modx->getOption('includeTVs', $scriptProperties, false);
$includeTVList = !empty($includeTVList) ? explode(',', $includeTVList) : array();

if ($includeTVs) {
    if (!empty($includeTVList)) {
        $tvs = $modx->getCollection('modTemplateVar', array('name:IN' => $includeTVList));
    } else {
        $tvs = $doc->getMany('TemplateVars');
    }

    foreach($tvs as $tvId => $templateVar) {
        /** @var $templateVar modTemplateVar */
        $fields[$templateVar->get('name')] = $templateVar->renderOutput($docId);
    }
}
/* See the MandrillExampleTpl chunk */
$tpl = $modx->getChunk('MandrillExampleTpl', $fields);
if (empty($tpl)) {
    die('No Tpl');
}

/* Message HTML content and text content can be set here,
 * but it's often better to send them later in the process
 * with setHTML() and setText(). See below */

// $scriptProperties['html'] = $tpl;

/* Mandrill will add the plain text version automatically if
   set in your account options at mandrillapp.com */

// $scriptProperties['text'] = strip_tags($html);

unset($tvs, $tvId, $tvName, $fields, $doc);

$mx = new MandrillX($modx, $apiKey, $scriptProperties);
$mx->init();


/* These will be the same for every message, so it's
   usually easier to set them in MODX before setting
   the message content */

$globalMergeVars = array();
$mx->setGlobalMergeVars($globalMergeVars);

/* Important!!! These need to be changed to real email addresses */

/* email and name are required.
 * Any other fields will be used to replace
 * {{+tagName}} placeholders in the Tpl chunk
 */

$user = array(
    'email' => 'janedoe@somewhere.com',
    'name' => 'Jane Doe',
    'firstname' => 'Jane',
    'lastname' => 'Doe',
    'username' => 'JaneDoe',
);

$mx->addUser($user);

$user = array(
    'email'          => 'joeblow@gmail.com',
    'name'           => 'Joe Blow',
    'firstname'      => 'Joe',
    'lastname'       => 'Blow',
    'username'       => 'JoeBlow',
);

$mx->addUser($user);
$mx->setHTML($tpl);
$mx->setText(strip_tags($tpl));
$results = $mx->sendMessage();

$output = '';

// print_r($results);
foreach($results as $result) {
    if ($result['status'] == 'sent') {
        $output .= "\n" . $result['email'] . ' - Success';
    } else {
        $msg = empty($result['reject_reason'])? $result['status'] : $result['reject_reason'];
        $output  .= "\n" . $result['email'] . ' Rejected: ' . $msg;
    }
}

if (php_sapi_name() == 'cli') {
    echo $output;
} else {
    return nl2br($output);
}


