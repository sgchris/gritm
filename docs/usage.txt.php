<?
/**
 * Example of the framework usage
 * Create one page, with one table, which has a few fields in it
 */

// create the login field
$loginField = new Field_Text('Login', 'login', 150);
$loginField->editable(false);

// create upload image field
$imageField = new Field_Image('User Pic.', 'userpic', 200);
$imageField->setUploadDir(ROOT_DIR.'userpics')
	->resize(150, 200)
	->keepOriginalImage(ROOT_DIR.'userpics/originals')
	->keepOriginalName(true); 
	// ->setNamePrefix('userpic_') 	// adds 'userpic_' to the image name
	// ->setNamePrefix(true) 		// adds uniqid hash to the image name

// create table
$table = new Table('db_table_name');
$table->orderBy('display_order')
	->add($loginField)
	->add(new Field_Password('Passwd', 'password', 150))
	->add(new Field_Email('Email', 'email', 200))
	->add($imageField)

	->manageOrder('true')
	->addPaging();

// create one page
$page = new Page('Test Page', 'test-page-url');
<<<<<<< HEAD
$page->add($table);
=======
$page->showButtonBack()
	->add($table);
>>>>>>> ba636dd09a26f9c51ac4612f540516f34fffdf8d

// create the application
$app = new Application('Example app');
$app->add($page)
	->run();