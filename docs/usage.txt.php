<?


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

$page = new Page('Test Page', 'test-page-url');
$page->showButtonBack()
	->add($table);

$app = new App('Example app');
$app->add($page);

$app->show();