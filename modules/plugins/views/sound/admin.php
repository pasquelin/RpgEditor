<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row_form">
    <label>
        <span class="titreSpanForm"><?php    echo    Kohana::lang('action.sound');    ?></span>
        <select name="sound" class="input-select">
            <?php    if ($sounds)    : ?>
                <?php foreach ($sounds as $val)    : ?>
                    <option value="<?php echo    $val; ?>" <?php    echo    isset($data->sound) && $val == $data->sound ? 'selected="selected"' : '';    ?> ><?php    echo    $val;    ?></option>
                <?php endforeach ?>
            <?php endif    ?>
        </select>
    </label>

    <div class="clear"></div>
</div>
