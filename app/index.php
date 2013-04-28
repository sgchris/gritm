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

$t2 = new Table('Key-Value (Pass) table', 'test');
$t2->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Password('Value(Password)', 'value', 150))
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$ta = new Field_Textarea('Value', 'value', 350);
$ta->setWidth(300)->setHeight(100);

$t3 = new Table('Key-Value (TA) table', 'test');
$t3->add(new Field_Text('Key', 'key', 150))
        ->add($ta)
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$t4 = new Table('Key-Value (Checkbox) table', 'test');
$t4->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Checkbox('Bool value', 'value', 300))
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$file = new Field_File('File value', 'value', 300);
$file->setUploadDir('upload_test_files');
$t5 = new Table('Key-Value (Checkbox) table', 'test');
$t5->add(new Field_Text('Key', 'key', 150))
        ->add($file)
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$image = new Field_Image('File value', 'value', 300);
$image->setUploadDir('upload_test_images')->setPreserveOriginalFileName(false);
$t6 = new Table('Key-Value (Checkbox) table', 'test');
$t6->add(new Field_Text('Key', 'key', 150))
        ->add($image)
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$image2 = new Field_Image('Small File', 'value', 300);
$image2->setUploadDir('upload_test_images_w_originals')
        ->setPreserveOriginalFileName(true)
        ->setPreviewWidth(80)
        ->resize(80, null, $originalImageFieldName = 'value2');
$origImage = new Field_Image('Original image', 'value2', 300);
$origImage->setReadOnly(true);

$t8 = new Table('Key-Value (Checkbox) table', 'test');
$t8->add(new Field_Text('Key', 'key', 150))
        ->add($origImage)
        ->add($image2)
        ->add(new Field_Date('Date C.', 'date_created', '200'))
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$t9 = new Table('Wysiwyg field test', 'test');
$t9->add(new Field_Text('Key', 'key', 150))
        ->add(new Field_Wysiwyg('Content', 'value', 150))
        ->orderBy('id', Table::ORDER_DESCENDING)
        ->setTotalRows(50);

$g1 = new Table_Gallery('Gallery Test', 'galleries');
$g1->setImagesTable('images', 'gallery_id')
        ->add(new Field_Text('Name', 'name'));

//////////////// PAGES //////////////////////

$p2 = new Page('Key-value password page', 'key-value-password-test');
$p2->add($t2);

$p3 = new Page('Key-value textarea page', 'key-value-textarea-test');
$p3->add($t3);

$p4 = new Page('Key-value checkbox page', 'key-value-checkbox-test');
$p4->add($t4);

$p5 = new Page('Key-value file page', 'key-value-file-test');
$p5->add($t5);

$p6 = new Page('Key-value image page', 'key-value-image-test');
$p6->add($t6);

$p8 = new Page('Images/w/Origs', 'images-with-their-originals');
$p8->setIcon('icon-picture')
        ->add($t8);

$p9 = new Page('Wysiwyg-test', 'wysiwyg-test');
$p9->add($t9);

$p10 = new Page('Gallery test', 'gallery-test');
$p10->add($g1);

///////////////////////////////////////////////////////
//$app->add($p1);
//$app->add($p2);
//$app->add($p3);
//$app->add($p4);
//$app->add($p5);
$app->add($p6);
$app->add($p8);
$app->add($p9);
$app->add($p10);

$app->run();

