<?php

$PORT = 20222; //the port on which we are connecting to the "remote" machine
$HOST = "78.47.250.95"; //the ip of the remote machine (in this case it's the same machine)

$sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
		or die("error: could not create socket\n");

$succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
		or die("error: could not connect to host\n");
$message = array("key" => array("key" =>"value"));
$text = "Hello, Java!"; //the text we want to send to the server

socket_write($sock, $text . "\n", strlen($text) + 1) //Writing the text to the socket
		or die("error: failed to write to socket\n");

$reply = socket_read($sock, 10000, PHP_NORMAL_READ) //Reading the reply from socket
		or die("error: failed to read from socket\n");

echo $reply;
?>