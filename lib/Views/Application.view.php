<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->getName() ?></title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/datepicker.min.css" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/my.css" />

        <script src="<?= $this->_request->getRelativePath() ?>/js/jquery.min.js"></script>
        <script src="<?= $this->_request->getRelativePath() ?>/js/bootstrap.min.js"></script>
        <script src="<?= $this->_request->getRelativePath() ?>/js/bootstrap-datepicker.min.js"></script>
        <script>var _HTTP_ROOT = "<?= $this->_request->getRelativePath() ?>";</script>
        <script src="<?= $this->_request->getRelativePath() ?>/js/gritm.js"></script>
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
                                    <i class="<?= $page->getIcon() ?>"></i> <?= htmlentities($page->getName(), ENT_NOQUOTES, 'utf-8') ?>
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
                    <ul class="nav nav-pills">
                        <? foreach ($applicationPages as $page) { ?>
                            <li<?= ($currentPageUrl == $page->getUrl() ? ' class="active"' : '') ?>>
                                <a href="<?= $this->_request->getRelativePath() ?>/<?= $page->getUrl() ?>">
                                    <i class="<?= $page->getIcon() ?>"></i> <?= htmlentities($page->getName(), ENT_NOQUOTES, 'utf-8') ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                    <small class="muted pull-right">
                        All rights reserved to GriTM 2013&copy;
                    </small>
                </nav>
            </footer>
        </div>
        <? if (!empty($currentPageJavascript)) { ?>
            <script>(function() {
    <?= $currentPageJavascript ?>
                })();</script>
        <? } ?>
    </body>
</html>