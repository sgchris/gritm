<?php

/**
 * Description of a file
 * 
 * @since Mar 17, 2013
 * @author Gregoryc
 */
require_once __DIR__ . '/../Gritm.php';

$t = new Table('Demo table', 'test');
$t->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Text('Value', 'value', 150));

$p = new Page('Demo Page', 'demo-page');
$p->add($t);

$app = new Application;
$app->add($p);

$app->run();