<h3><?= htmlentities($this->_name, ENT_NOQUOTES, 'utf-8') ?></h3>

<? /* BUTTONS */ ?>
<div class="btn-group">
    <? foreach ($buttonsList as $button) { ?>
        <?= $button->getHtml() ?>
    <? } ?>
</div>

<? /* TABLE */ ?>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>#</th>
            <? foreach ($fieldsList as $field) { ?>
                <th width="<?= $field->getWidth() ?>">
                    <?= htmlentities($field->getName(), ENT_NOQUOTES, 'utf-8') ?>
                </th>
            <? } ?>
        </tr>
    </thead>

    <tbody>
        <? foreach ($recordSetRows as $row) { ?>
            <tr>
                <? foreach ($fieldsList as $field) { ?>
                    <td>
                        <?
                        echo $field
                                ->setValue($row[$field->getDbName()], $row)
                                ->getHtml();
                        ?>
                    </td>
                <? } ?>
            </tr>
        <? } ?>
    </tbody>
</table>

<? /* BUTTONS */ ?>
<div class="btn-group">
    <? foreach ($buttonsList as $button) { ?>
        <?= $button->getHtml() ?>
    <? } ?>
</div>

