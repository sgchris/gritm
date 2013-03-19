<?php

require_once __DIR__ . '/UnitTest.php';
require_once __DIR__ . '/../Tools/Request.php';
require_once __DIR__ . '/../HTMLCollection/Application.php';

class ApplicationTest extends UnitTest {

    public function testBasicHtml() {
        $app = new Application('Test App');
        $appHtml = $app->run($returnHtml = true);

        $startsWithDoctype = preg_match('%^<\\!DOCTYPE html%', $appHtml);
        $this->assertTrue($startsWithDoctype);

        $endsWithHtmlTag = preg_match('%</html>$%', $appHtml);
        $this->assertTrue($endsWithHtmlTag);
    }

    public function testAppWithoutLayout() {
        $app = new Application('Test App');
        $app->disableLayout();
        $appHtml = $app->run($returnHtml = true);

        $startsWithDoctype = preg_match('%^<\\!DOCTYPE html%', $appHtml);
        $this->assertFalse($startsWithDoctype);

        $endsWithHtmlTag = preg_match('%</html>$%', $appHtml);
        $this->assertFalse($endsWithHtmlTag);
    }

}

$at = new ApplicationTest();
$at->run();

