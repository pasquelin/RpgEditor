<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<article class="module width_full relative">
    <header>
        <h3 class="tabs_involved"><?php echo $row->title; ?></h3>
    </header>
    <div class="module_content">
        <p class="form-line">
            <label for="title" class="form-label"><?php echo Kohana::lang('article.title'); ?> : <span
                    class="p-lower"><?php echo Kohana::lang('form.minus'); ?></span></label>
            <input name="title" id="title" value="<?php echo $row->title; ?>" class="inputbox input-text" type="text"/>
        </p>

        <p class="form-line">
            <label for="article_category_id" class="form-label"><?php echo Kohana::lang('article.category'); ?>
                :</label>
            <select name="article_category_id" id="article_category_id" class="inputbox">
                <?php foreach ($actualiteCategories as $val) : ?>
                    <option
                        value="<?php echo $val->id_article_category; ?>" <?php echo ($val->id_article_category == $row->article_category_id) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($val->name); ?></option>
                <?php endforeach ?>
            </select>
        </p>
        <p class="form-line">
            <label for="status" class="form-label"><?php echo Kohana::lang('article.status'); ?> :</label>
            <select class="inputbox" name="status" id="status">
                <option value="1" class="vert"><?php echo Kohana::lang('form.actif'); ?></option>
                <option value="0" class="rouge" <?php if (!$row->status)
                    echo 'selected="selected"'; ?>><?php echo Kohana::lang('form.no_actif'); ?></option>
            </select>
        </p>
        <p class="form-line">
            <label for="url" class="form-label"><?php echo Kohana::lang('article.url'); ?> : </label>
            <input id="url"
                   value="<?php echo str_replace(array('admin/', '../'), '', url::base(TRUE) . '../article/') . base64_encode($row->id_article); ?>"
                   class="inputbox input-text" type="text"/>
        </p>

        <p class="form-line">
            <label for="region_id" class="form-label"><?php echo Kohana::lang('article.region'); ?> :</label>
            <select name="region_id" id="region_id" class="inputbox">
                <?php if ($regions) : ?>
                    <?php foreach ($regions as $val) : ?>
                        <option
                            value="<?php echo $val->id; ?>" <?php echo ($val->id == $row->region_id) ? 'selected="selected"' : ''; ?>
                            style="padding-left:<?php echo $val->level * 12; ?>px;"><?php echo $val->name; ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </p>
        <p>
            <?php Fck_Core::editeur('article', isset($row->article) ? $row->article : ''); ?>
        </p>

        <p>
            <?php Fck_Core::editeur('reponse', isset($row->reponse) ? $row->reponse : ''); ?>
        </p>
    </div>
    <div class="clear"></div>
</article>
