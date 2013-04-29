<div class="page-header">
    <h2><?= htmlentities($this->_name, ENT_NOQUOTES, 'utf-8') ?></h2>
</div>
<? if (isset($buttonsHtml) && !empty($buttonsHtml)) { ?>
    <div class="btn-group">
        <?= $buttonsHtml ?>
    </div>
<? } ?>

<?= $tablesHtml ?>

<? if (isset($buttonsHtml) && !empty($buttonsHtml)) { ?>
    <div class="btn-group">
        <?= $buttonsHtml ?>
    </div>
<? } ?>
