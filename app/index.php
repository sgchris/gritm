<?php

/**
 * Index file for the application
 * 
 * @since Mar 18, 2013
 * @author Gregoryc
 */
$app = new Application('Demo Zips Application');
$app->setDescription('Administration panel for the demo zips application');

///////////////////////////////////////////////////////
$t = new Table('U.S. Zip Codes', 'zipcodes_2011');
$t->setPkField('zipcode')
        ->add(new Field_Text('The City', 'city', 250))
        ->add(new Field_Text('The State', 'state', 50))
        ->orderBy('zipcode', Table::ORDER_ASCENDING);


$t2 = new Table('Demo table #2', 'test');
$t2->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Text('Value', 'value', 150))
        ->orderBy('value', Table::ORDER_ASCENDING)
        ->setTotalRows(50);


$p1 = new Page('Zips', 'zips-page');
$p1->add($t)->add($t2);

$app->add($p1);


///////////////////////////////////////////////////////
$p2 = new Page('Demo Page (Table Manipulation)', 'demo-page-table-manipulation');
//$p->add($t);
$app->add($p2);

$app->run();

