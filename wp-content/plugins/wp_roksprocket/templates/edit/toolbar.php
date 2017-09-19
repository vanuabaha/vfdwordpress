<?php
/**
 * Created by JetBrains PhpStorm.
 * User: steph
 * Date: 12/3/11
 * Time: 2:58 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="toolbar-wrapper">
    <ul class="toolbar">
        <?php foreach ($that as $key => $button): ?>
        <?php if (!isset($button['data_save']) || $button['data_save'] != 'saveascopy' || ($button['data_save'] == 'saveascopy' && $data_id > 0)): ?>
        <li id="<?php if(isset($button['id'])) echo $button['id'];?>" rel="<?php if(isset($button['rel'])) echo $button['rel'];?>"
            class="toolbar-button">
            <a class="toolbar btn<?php if (isset($button['extra_class'])) { echo ' ' . $button['extra_class'];}?>" href="<?php echo $button['link'];?>" <?php if (isset($button['data_save'])): ?>data-roksprocket-save="<?php echo $button['data_save']; ?>"<?php endif; ?>>
                <?php if (isset($button['data_save'])): ?><img src="<?php echo $site_url; ?>/wp-content/plugins/wp_roksprocket/admin/assets/images/wpspin_<?php echo (isset($button['extra_class']) && preg_match("/btn-primary/", $button['extra_class'])) ? 'dark' : 'light'; ?>.gif" /><?php endif; ?>
                <span class="<?php echo $button['class'];?>" title="<?php echo $button['title'];?>"></span>
                <?php echo $button['title'];?>
            </a>

        </li>
        <?php endif; ?>
        <?php endforeach;?>
    </ul>
</div>
<div style="clear:both;"></div>
