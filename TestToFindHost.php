<?php 
$ip = getenv("REMOTE_ADDR") ;
$user = getenv('C9_USER');

Echo "Your IP is " . $ip; 
Echo "User is ". $user;
?> 