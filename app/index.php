<?php

/**
 * Index file for the application
 * 
 * @since Mar 18, 2013
 * @author Gregoryc
 */
$app = new Application('Demo Application');
$app->setDescription('Administration panel for the demo application');

///////////////////////////////////////////////////////
$t = new Table('Favorites', 'test');
$t->add(new Field_Text('Discipline', 'key', 100))
        ->add(new Field_Text('Person', 'value', 250));

$p = new Page('Demo Page', 'demo-page');
$p->add($t);

$app->add($p);


///////////////////////////////////////////////////////
$t = new Table('Demo table #2', 'test');
$t->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Text('Value', 'value', 150))
        ->orderBy('value', Table::ORDER_ASCENDING)
        ->setTotalRows(50);

$p = new Page('Demo Page (Table Manipulation)', 'demo-page-table-manipulation');
$p->add($t);
$app->add($p);

$app->run();

