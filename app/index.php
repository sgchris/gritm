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
$t = new Table('Demo table', 'test');
$t->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Text('Value', 'value', 150));

$p = new Page('Demo Page', 'demo-page');
$p->add($t);

$app->add($p);


///////////////////////////////////////////////////////
$t = new Table('Demo table #2', 'test');
$t->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Text('Value', 'value', 150));

$p = new Page('Demo Page #2', 'demo-page-2');
$p->add($t);
$app->add($p);

$app->run();

