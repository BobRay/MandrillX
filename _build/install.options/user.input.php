<?php

/**
 * Script to interact with user during MandrillX package install
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

/**
 * Description: Script to interact with user during MandrillX package install
 * @package mandrillx
 * @subpackage build
 */

/* The return value from this script should be an HTML form (minus the
 * <form> tags and submit button) in a single string.
 *
 * The form will be shown to the user during install
 *
 * This example presents an HTML form to the user with two input fields
 * (you can have as many as you like).
 *
 * The user's entries in the form's input field(s) will be available
 * in any php resolvers with $modx->getOption('field_name', $options, 'default_value').
 *
 * You can use the value(s) to set system settings, snippet properties,
 * chunk content, etc. based on the user's preferences.
 *
 * One common use is to use a checkbox and ask the
 * user if they would like to install a resource for your
 * component (usually used only on install, not upgrade).
 */

/* This is an example. Modify it to meet your needs.
 * The user's input would be available in a resolver like this:
 *
 * $changeSiteName = (! empty($modx->getOption('change_sitename', $options, ''));
 * $siteName = $modx->getOption('sitename', $options, '').
 *
 * */

$output = '<p>&nbsp;</p>
<p>Enter your Mandrill API Key. If you don\'t have one yet, you can leave it blank and set the mandrill_api_key System Setting later (or get one now at <a href="https://mandrillapp.com" target="_blank" >Mandrill</a>).</p>
<p>&nbsp;</p>
<label for="api_key">API Key.</label>
<p>&nbsp;</p>
<input type="text" name="api_key" id="api_key" value="" size="40" maxlength="60" />
<p>&nbsp;</p>
<p>&nbsp;</p>';


return $output;