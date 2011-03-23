#!/usr/local/bin/php
<?php
//^^ adrress php-cgi
//how use it ./1.php 123.123.123 27015 26666


$s_ip=$argv[1];//Grab vars
$s_port=$argv[2];
$d_port=$argv[3];

//Init Socks
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, '0.0.0.0',$d_port);

while (true) //inf loop
{
  if (($len = @socket_recvfrom($socket,$buf,2048,0,$c_ip,$c_port)) != false)
  {
    if ( ($c_ip<>$s_ip) OR ($c_port<>$s_port) ) //Ignore others servers
    {
      continue;
    }
    $buf=utf8_decode ($buf );
    if (substr($buf,0,4)!="?RL ") //Ignore bad Packet
    {
      continue;
    }
// HERE BEGINS MAGIC
	$log .= $len.'\n';
	// detect game end
	if(parseLine($len) == 2) {
		parse($log);
		break;
	}
  }
}
?>