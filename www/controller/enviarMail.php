<?php
include('Mail.php');
$recipients = 'someuser@somedomain.com';
$headers['From']    = 'notifications@iamon.com';
$headers['To']      = 'someuser@somedomain.com';
$headers['Subject'] = 'Switch has been switched on!';
$body = 'The Switch xxxx you are subscribed to has been powered on!!';
$params['host'] = '172.24.160.1'; //esta es la IP de la máquina host cuando se usa docker, allí hay un fakesmtp
$params['port'] = '2525'; // puerto del fakesmtp
// Create the mail object using the Mail::factory method
$mail_object = Mail::factory('smtp', $params);
$mail_object->send($recipients, $headers, $body);
?> 