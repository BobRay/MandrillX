<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';
//require dirname(__FILE__) . '/vendor/mandrill/mandrill/src/' . 'Mandrill.php';

$mandrill = new Mandrill('3FTnv3CbpKZI3bxldmP2vw');

$message = array(
    'headers'             => array('Reply-To' => 'bobray@bobsguides.com'),
    'important'           => false,
    'track_opens'         => NULL,
    'track_clicks'        => NULL,
    'auto_text'           => true,
    'auto_html'           => NULL,
    'inline_css'          => NULL,
    'url_strip_qs'        => NULL,
    'preserve_recipients' => NULL,
    'view_content_link'   => NULL,
    'bcc_address'         => NULL,
    'tracking_domain'     => NULL,
    'signing_domain'      => NULL,
    'return_path_domain'  => NULL,
    'merge'               => true,
    'subject' => NULL,
    'from_email' => 'bob@bobsguides.com',
    'html' => '<p>this is a test message with Mandrill\'s PHP wrapper!.</p>',
    'to' => array(
        array(
            'email' => 'bobray99@gmail.com',
            'name' => 'Joe Blow'
        ),
        array(
            'email' => 'bobray@softville.com',
            'name'  => 'Bob'
        ),
        array(
            'email' => 'bobray@nowhere',
            'name' => 'Bad Email',
        ),
    ),
    /* These are the same in every message */
    'global_merge_vars' => array(
        array(
            'name'    => 'SUMMARY',
            'content' => 'This is the summary',
        ),

        array(
            'name'    => 'PAGEURL',
            'content' => 'http://bobsguides.com/modx/',
        ),
        array(
            'name'    => 'PAGETITLE',
            'content' => 'MyPage',
        ),

    ),
    /* These are different for each user */
    'merge_vars' => array(
        array(
            'rcpt' => 'bobray99@gmail.com',
            'vars' =>
            array(
                array(
                    'name' => 'FIRSTNAME',
                    'content' => 'Joe'),
                array(
                    'name' => 'LASTNAME',
                    'content' => 'Blow'),
                array(
                    'name'    => 'UNSUBSCRIBEURL',
                    'content' => 'http://bobsguides.com/unsubscribe.html',
                ),
                array(
                    'name'    => 'USERNAME',
                    'content' => 'someUserName',
                ),
            )
        ),
        array(
            'rcpt' => 'bobray@softville.com',
            'vars' =>
                array(
                    array(
                        'name'    => 'FIRSTNAME',
                        'content' => 'Bob'
                    ),
                    array(
                        'name'    => 'LASTNAME',
                        'content' => 'Ray'
                    ),
                    array(
                        'name'    => 'UNSUBSCRIBEURL',
                        'content' => 'http://bobsguides.com/bobsunsubscribe.html',
                    ),
                )
        ),
        array(
            'rcpt' => 'bobray@nowhere',
            'vars' =>
                array(
                    array(
                        'name'    => 'FIRSTNAME',
                        'content' => 'Bob'
                    ),
                    array(
                        'name'    => 'LASTNAME',
                        'content' => 'Ray'
                    ),
                    array(
                        'name'    => 'UNSUBSCRIBEURL',
                        'content' => 'http://bobsguides.com/bobsunsubscribe.html',
                    ),
                )
        )


    )
);

$template_name = 'Notify-Update';

$template_content = array(
    array(
        'name' => 'main',
        'content' => 'Hi *|FIRSTNAME|* *|LASTNAME|*, thanks for signing up.'),
    array(
        'name' => 'footer',
        'content' => 'Copyright 2012.')

);

$results = $mandrill->messages->sendTemplate($template_name, $template_content, $message);
$output = '';

// print_r($results);
foreach($results as $result) {
    if ($result['status'] == 'sent') {
        $output .= "\n" . $result['email'] = 'Success';
    } else {
        $msg = empty($result['reject_reason'])? $result['status'] : $result['reject_reason'];
        $output  .= "\n" . 'Rejected: ' . $msg;
    }
}

if (php_sapi_name() == 'cli') {
    echo $output;
} else {
    return nl2br($output);
}


