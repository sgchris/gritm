<?php

require_once dirname(__FILE__) . '/../../../lib/HTMLCollection/Table.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-18 at 14:40:06.
 */
class TableTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Table
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Table('Test table', 'test');
        $this->object->add(new Field('Key', 'key'));
        $this->object->add(new Field('Value', 'value'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    /**
     * @covers Table::getHtml
     * @todo   Implement testGetHtml().
     */
    public function testGetHtml() {
        $html = $this->object->getHtml();
        
        // check that there is a table element
        $this->assertRegExp('%<table(.*?)</table%smi', $html);
        
        // check that there are the fields
        $this->assertRegExp('%<th(.*?)Key(.*?)</th>%smi', $html);
        $this->assertRegExp('%<th(.*?)Value(.*?)</th>%smi', $html);
    }

}