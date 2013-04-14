<?php

/**
 * Index file for the application
 * 
 * @since Mar 18, 2013
 * @author Gregoryc
 */
$app = new Application('Demo Zips Application');
$app->setDescription('Administration panel for the demo zips application');

//////////////////////// TABLES ///////////////////////////////
$t = new Table('U.S. Zip Codes', 'zipcodes_2011');
$t->setPkField('zipcode')
        ->add(new Field_Text('Zip Code', 'zipcode', 100))
        ->add(new Field_Text('The City', 'city', 250))
        ->add(new Field_Text('The State', 'state', 50))
        ->orderBy('zipcode', Table::ORDER_ASCENDING);


$t2 = new Table('Key-Value (Pass) table', 'test');
$t2->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Password('Value(Password)', 'value', 150))
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$ta = new Field_Textarea('Value', 'value', 350);
$ta->setHeight(300)->setHeight(100);

$t3 = new Table('Key-Value (TA) table', 'test');
$t3->add(new Field_Text('Key', 'key', 150))
        ->add($ta)
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);


//////////////// PAGES //////////////////////

$p1 = new Page('Zips', 'zips-page');
$p1->add($t);


$p2 = new Page('Key-value password page', 'key-value-password-test');
$p2->add($t2);

$p3 = new Page('Key-value textarea page', 'key-value-textarea-test');
$p3->add($t3);

///////////////////////////////////////////////////////

$app->add($p1);
$app->add($p2);
$app->add($p3);

$app->run();

