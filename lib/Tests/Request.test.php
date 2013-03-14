<?php

require_once __DIR__.'/../Tools/Request.php';

echo '<b> This test is valid on Dev.Mode only, where the dir is "/gritm"</b><br><br>';

echo 'right document root<br>';
$_server_document_root = $_SERVER['DOCUMENT_ROOT'];

$RightReq = new Request;
$RightReq->parse();

if (($rightRelativePath = $RightReq->getRelativePath()) !== '/gritm') {
	echo 'ERROR - ', $RightReq->getRelativePath(); 
} else {
	echo 'Ok';
}
echo '<br>';




echo 'document root is one above the real<br>';
$_SERVER['DOCUMENT_ROOT'] = 'C:\\xampp';
$req = new Request;
$req->parse();

if ($req->getRelativePath() !== '/htdocs/gritm') {
	echo 'ERROR - ', $req->getRelativePath(); 
} else {
	echo 'Ok';
}
echo '<br>';




echo 'same document root<br>';
$_SERVER['DOCUMENT_ROOT'] = 'C:\\xampp\\htdocs\\gritm';
$req = new Request;
$req->parse();

if ($req->getRelativePath() !== '') {
	echo 'ERROR - ', $req->getRelativePath(); 
} else {
	echo 'Ok';
}
echo '<br>';


echo 'bad document root<br>';
$_SERVER['DOCUMENT_ROOT'] = 'D:\\xampp\\htdocs\\gritm';
$req = new Request;
$req->parse();

$expected = rtrim(str_replace('\\', '/', $_server_document_root), '/').$rightRelativePath;

if ($req->getRelativePath() !== $expected) {
	echo 'ERROR - ', $req->getRelativePath(), ', exptected - ', $expected; 
} else {
	echo 'Ok';
}
echo '<br>';



echo '<br>--------------------------------------------------<br><br><br>';


// $RightReq