<?php

use PAMI\Client\Exception\ClientException;
use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\OriginateAction;

require __DIR__ . '/vendor/autoload.php';

// Settings of the Asterisk
$options = array(
    'host' => '2.3.4.5',
    'scheme' => 'tcp://',
    'port' => 9999,
    'username' => 'asd',
    'secret' => 'asd',
    'connect_timeout' => 10,
    'read_timeout' => 10
);
$client = new ClientImpl($options);

try {
    // Connect to Asterisk
    $client->open();

    // file to play
    $playFile = '/files/hello.wav';
    // the number a callee will get on the screen
    $callerId = '380440441012';
    // callee number
    $callNumber = '380631010120';
    // channel with the extension from which we want to call
    $channel = 'Local/1000@from-internal';

    // Configure action
    $action = new OriginateAction($channel);
    $action->setAsync(true); // the call will be asynchronous
    $action->setCallerId($callerId);
    $action->setTimeout('15');
    $action->setData($playFile);
    $action->setApplication('Playback');
    $action->setPriority('1');
    $action->setContext('from-internal');
    $action->setExtension($callNumber);
    // $action->setCodecs(array('a', 'b'));
    // $action->setAccount('account');
    // $action->setVariable('a', 'b');

    // Send this action
    $result = $client->send($action);

    // Print result
    var_dump($result);

    // Close the connection
    $client->close();
} catch (ClientException $e) {
    // Print errors
    echo $e->getMessage();
}
