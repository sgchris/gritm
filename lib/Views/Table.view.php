<h3><?= htmlentities($this->_name, ENT_NOQUOTES, 'utf-8') ?></h3>

<? /* BUTTONS */ ?>
<div class="btn-group">
    <? foreach ($buttonsList as $button) { ?>
        <?= $button->getHtml() ?>
    <? } ?>
</div>

<? /* TABLE */ ?>
<table class="table table-bordered table-striped table-hover" table-db-name="<?= $this->getDbName() ?>">
    <thead>
        <tr>
            <th width="<?= $this->getPkFieldWidth(); ?>">#</th>
            <? foreach ($fieldsList as $field) { ?>
                <th width="<?= $field->getWidth() ?>"><?=
                    htmlentities($field->getName(), ENT_NOQUOTES, 'utf-8')
                    ?></th>
            <? } ?>
        </tr>
    </thead>

    <tbody>
        <? if (is_array($recordSetRows)) { ?>
            <? foreach ($recordSetRows as $row) { ?>
                <tr row-pk="<?= $row[$this->getPkField()] ?>">
                    <td><?= $row[$this->getPkField()] ?></td>
                    <? foreach ($fieldsList as $field) { ?>
                        <td field-db-name="<?= $field->getDbName() ?>" field-db-value="<?= $row[$field->getDbName()] ?>"><?
                            echo $field
                                    ->setValue($row[$field->getDbName()], $row)
                                    ->getHtml();
                            ?></td>
                    <? } ?>
                </tr>
            <? } ?>
        <? } else { ?>
        <td colspan="100%">Error getting data!</td>
    <? } ?>
</tbody>
</table>

<? /* BUTTONS */ ?>
<div class="btn-group">
    <? foreach ($buttonsList as $button) { ?>
        <?= $button->getHtml() ?>
    <? } ?>
</div>

