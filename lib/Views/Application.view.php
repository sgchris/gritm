<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->getName() ?></title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= $this->_request->getRelativePath() ?>/css/my.css" />
        <style><?= $this->getCss() ?></style>
            

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <? if ($this->_currentPage->hasWysiwyg()) { ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/44.1.0/ckeditor.js" integrity="sha512-zlAQuWNEUYYk/XDACXbjg8zqPHOEVbIGP5AB9nOKKE8hgZMHRaGmXnOsYiwVJIBHoFHb0ssgByYbAgl0Zo2KEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <? } ?>
        <script>var _HTTP_ROOT = "<?= $this->_request->getRelativePath() ?>";</script>
        <script type="module" src="<?= $this->_request->getRelativePath() ?>/js/gritm.modern.js"></script>
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