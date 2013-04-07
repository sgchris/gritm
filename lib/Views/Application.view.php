<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->getName() ?></title>
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/my.css" />

        <script src="<?= $this->_request->getRelativePath() ?>/js/jquery.min.js"></script>
        <script src="<?= $this->_request->getRelativePath() ?>/js/bootstrap.min.js"></script>
        <script>var _HTTP_ROOT = "<?= $this->_request->getRelativePath() ?>";</script>
        <script src="<?= $this->_request->getRelativePath() ?>/js/gritm.js"></script>
        <script>
            /*
            $(function() {
                Gritm.popup.show({
                    title:'greg',
                    html: 'This is some popup <b>HTML</b>',
                    buttons: [{
                            caption: 'test button1',
                            click: function(popup) {
                                console.log('popup', popup);
                            }
                    }]
                });
                
                
                Gritm.popup.show({
                    title:'greg',
                    html: 'This is some popup <b>HTML</b>',
                    closeButton: true,
                    buttons: [{
                            caption: 'test button2',
                            click: function(popup) {
                                console.log('popup', popup);
                            }
                    }]
                });                
            });
            */
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <header class="page-header">
                <h1><?= $this->getName() ?> <small><?= $this->getDescription() ?></small></h1>
            </header>
            <section class="main-section row-fluid">
                <nav class="span3 well sidebar-nav">
                    <ul class="nav nav-list nav-pills nav-stacked">
                        <li class="nav-header">Pages</li>
                        <? foreach ($applicationPages as $page) { ?>
                            <li<?= ($currentPageUrl == $page->getUrl() ? ' class="active"' : '') ?>>
                                <a href="<?= $this->_request->getRelativePath() ?>/<?= $page->getUrl() ?>">
                                    <?= htmlentities($page->getName(), ENT_NOQUOTES, 'utf-8') ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>

                <section class="span9">
                    <?= $currentPageHtml ?>
                </section>
            </section>

            <footer class="navbar-static-bottom navbar-fixed-bottom well well-small">
                <nav>
                    <small class="muted pull-right">
                        All rights reserved to GriTM 2013&copy;
                    </small>
                    <ul class="nav nav-pills">
                        <? foreach ($applicationPages as $page) { ?>
                            <li<?= ($currentPageUrl == $page->getUrl() ? ' class="active"' : '') ?>>
                                <a href="<?= $this->_request->getRelativePath() ?>/<?= $page->getUrl() ?>">
                                    <?= htmlentities($page->getName(), ENT_NOQUOTES, 'utf-8') ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>
            </footer>
        </div>

    </body>
</html>