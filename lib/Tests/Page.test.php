<?php

require_once __DIR__ . '/UnitTest.php';
require_once __DIR__ . '/../Tools/Request.php';
require_once __DIR__ . '/../HTMLCollection/Page.php';

class PageTest extends UnitTest {

    public function testResponsiblePage() {

        $originalRequestUri = $_SERVER['REQUEST_URI'];
        $_SERVER['REQUEST_URI'] = '/gritm/test-page';
        $p = new Page('Test page', 'test-page');
        $r = new Request;

        $this->assertTrue($p->isResponsibleFor($r));

        $_SERVER['REQUEST_URI'] = $originalRequestUri;
    }

    public function testIrresponsiblePage() {

        $originalRequestUri = $_SERVER['REQUEST_URI'];

        $_SERVER['REQUEST_URI'] = '/gritm/test-another-page';
        $p = new Page('Test page', 'test-page');
        $r = new Request;

        $this->assertFalse($p->isResponsibleFor($r));

        $_SERVER['REQUEST_URI'] = $originalRequestUri;
    }

}

$pt = new PageTest;
$pt->run();