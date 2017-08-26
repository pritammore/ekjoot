<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>

<div class="box-upload" id="box-upload">
    <div id="upload-container">
        <div id="aaiu-upload-container">
            <div id="gallery-upload-message"></div>
            <div id="aaiu-upload-imagelist"></div>
            <div id="imagelist"></div>
            <a href="javascript:void(0);" id="delete-embed" class="ui top right attached label" style="display: none;z-index: 100"><i class="trash icon"></i><?php _e('Delete', 'petition') ?></a>
            <div class="ui embed" id="embed-media" style="display: none">
            </div>
            <div class="ui center aligned basic segment" id="upload-tool">
                <div class="ui divider hidden"></div>
                <div class="ui divider hidden"></div>
                <img src="<?php echo get_template_directory_uri() ?>/images/image-placeholder-drop.svg" width="128" class="position-block-center">
                <div class="ui divider hidden"></div>
                <div class="ui divider hidden"></div>
                <a href="javascript:void(0);" id="aaiu-uploader" class="ui basic large button"><i class="folder outline open icon"></i><?php _e('Browse Images', 'petition');?></a>
                <input type="hidden" name="new_gallery" id="new_gallery">
                <div class="ui divider hidden"></div>
                <div class="ui horizontal divider"><?php _e('Or', 'petition') ?></div>
                <div class="ui divider hidden"></div>
                
                <div class="ui action fluid large input">
                  <input type="text" id="video_url" name="video_url" value="" placeholder="http://">
                  <a href="javascript:void(0)" class="ui button" id="embed-btn"><?php _e('Embed', 'petition') ?></a>
                </div>
                <input type="hidden" id="new_video" name="new_video" value="">
                <input type="hidden" id="new_thumb" name="new_thumb" value="">
                <input type="hidden" id="new_attach" name="new_attach" value="">
            </div>
        </div>
    </div>
</div>