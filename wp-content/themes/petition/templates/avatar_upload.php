<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>
<?php
$current_user = wp_get_current_user();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
}
$user_meta = get_user_meta($current_user->ID);
$up_avatar_orginal = get_user_meta($current_user->ID, 'avatar_orginal', true);
$up_avatar_id = get_user_meta($current_user->ID, 'avatar_id', true);
if ($up_avatar_orginal != '') {
    $up_avatar = $up_avatar_orginal;
} else {
    $up_avatar = get_user_meta($current_user->ID, 'avatar', true);
}
?>
<div class="<?php echo ($up_avatar ? '' : 'box-upload') ?>" id="box-upload">
    <div id="upload-container">
        <div id="aaiu-upload-container">
            <div id="aaiu-upload-imagelist"></div>
            <div id="imagelist">
                <?php if($up_avatar) { ?>
                    <div class="ui fluid bordered image" style="margin-bottom:10px">
                        <img src="<?php echo esc_url($up_avatar); ?>" alt="thumb" />
                        <label class="ui top right attached label deleteImage"><i class="right trash icon"></i>Delete</label>
                    </div>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="ui center aligned basic segment" id="upload-tool" style="<?php echo ($up_avatar ? 'display: none' : 'display: block') ?>">
                <img src="<?php echo get_template_directory_uri() ?>/images/avatar-placeholder.svg" width="128" class="position-block-center">
                <div class="ui divider hidden"></div>
                <a href="javascript:void(0);" id="aaiu-uploader" class="ui basic button"><i class="folder outline open icon"></i><?php _e('Browse Images', 'petition');?></a>
            </div>
            <input type="hidden" name="new_gallery" id="new_gallery" value="<?php echo ($up_avatar ? '~~~' . $up_avatar : '') ?>">
            <input type="hidden" id="new_attach" name="new_attach" value="<?php echo ($up_avatar_id ? $up_avatar_id : '') ?>">
        </div>
    </div>
</div>