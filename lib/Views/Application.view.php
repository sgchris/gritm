<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->getName() ?></title>
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap-responsive.min.css" />
    </head>
    <body>
        <div class="container-fluid">
            <header class="page-header">
                <h1><?= $this->getName() ?> <small><?= $this->getDescription() ?></small></h1>
            </header>
            <div class="row-fluid">
                <nav class="span2 well">
                    <ul class="nav nav-pills nav-stacked">
                        <? foreach ($applicationPages as $page) { ?>
                            <li>
                                <a href="<?= $this->_request->getRelativePath() ?>/<?= $page->getUrl() ?>">
                                    <?= htmlentities($page->getUrl(), ENT_NOQUOTES, 'utf-8') ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>

                <section class="span10">
                    <?= $currentPageHtml ?>
                </section>
            </div>
            
            <footer class="navbar-fixed-bottom well">
                <nav>
                    <ul class="nav nav-pills">
                        <? foreach ($applicationPages as $page) { ?>
                            <li>
                                <a href="<?= $this->_request->getRelativePath() ?>/<?= $page->getUrl() ?>">
                                    <?= htmlentities($page->getUrl(), ENT_NOQUOTES, 'utf-8') ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>

                <small class="muted pull-right">
                    All rights reserved to GriTM 2013&copy;
                </small>
                
            </footer>
        </div>
    </body>
</html>