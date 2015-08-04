<?php

$hasil = mysql_connect('localhost','root','');
if ($hasil) {
	mysql_select_db('butuh') or die('Database not found');
} else {
	die('Cant connect to MySQL');
}