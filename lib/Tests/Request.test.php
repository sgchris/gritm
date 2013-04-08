<?php

require_once __DIR__ . '/UnitTest.php';
require_once __DIR__ . '/../Tools/Request.php';

class RequestTest extends UnitTest {

    public function testRightRelativePath() {

        $RightReq = new Request;
        $RightReq->parse();

        $this->assertEquals($RightReq->getRelativePath(), '/gritm');
    }

    public function testWrongDocRoot() {
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        $_SERVER['DOCUMENT_ROOT'] = realpath($_SERVER['DOCUMENT_ROOT'] . '/..');

        $req = Request::getInstance();
        $req->parse();

        $this->assertEquals($req->getRelativePath(), '/htdocs/gritm');

        // restore the docroot
        $_SERVER['DOCUMENT_ROOT'] = $docRoot;
    }

    public function testUrlParam1() {
        $RequestUri = $_SERVER['REQUEST_URI'];
        $_SERVER['REQUEST_URI'] = '/gritm/get/some/file';

        $req = Request::getInstance();
        $req->parse();

        $this->assertEqualsStrict($req->getUrlParam(-3), null);
        $this->assertEquals($req->getUrlParam(0), 'get');
        $this->assertEquals($req->getUrlParam(1), 'some');
        $this->assertEquals($req->getUrlParam(2), 'file');
        $this->assertEqualsStrict($req->getUrlParam(3), null);

        // restore the docroot
        $_SERVER['REQUEST_URI'] = $RequestUri;
    }

}

$rt = new RequestTest;
$rt->run();