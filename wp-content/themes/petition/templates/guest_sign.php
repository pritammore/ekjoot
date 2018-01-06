<?php
/**
 * @package WordPress
 * @subpackage Petition
 */
?>
<?php if ( !wp_is_mobile() ) { ?>
<div class="ui divider hidden"></div>
<div class="respon-message" id="signMessage"></div>
<div class="ui form" id="userSignForm">
    <div class="field">
        <div class="ui right icon large input">
            <input type="text" name="nameSign" id="nameSign" placeholder="<?php _e('Full name', 'petition') ?>">
            <i class="user icon"></i>
        </div>
    </div>
    <div class="required field">
        <div class="ui right icon large input">
            <input type="text" name="emailSign" id="emailSign" placeholder="<?php _e('Email', 'petition') ?>">
            <i class="mail icon"></i>
        </div>
    </div>
    <div class="field">
        <div class="ui right icon large input">
            <input type="text" name="addressSign" id="addressSign" placeholder="<?php _e('Address', 'petition') ?>">
            <i class="marker icon"></i>
        </div>
    </div>
    <div class="field">
        <div class="ui right icon large input">
            <input type="text" name="pincodeSign" id="pincodeSign" placeholder="<?php _e('Pincode', 'petition') ?>">
            <i class="location arrow icon"></i>
        </div>
    </div>
    
    <input type="hidden" name="passSign" id="passSign" value="<?php echo wp_generate_password(6, false); ?>">
    <input type="hidden" id="citySign" name="citySign" value="">
    <input type="hidden" id="stateSign" name="stateSign" value="">
    <input type="hidden" id="neighborhoodSign" name="neighborhoodSign" value="">
    <input type="hidden" id="countrySign" name="countrySign" value="">
    <input type="hidden" id="latSign" name="latSign" value="">
    <input type="hidden" id="lngSign" name="lngSign" value="">

    <div class="field">
        <div class="ui pointing below fluid basic label font large">
            <textarea name="sign-comment" id="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
        </div>
        <div class="ui message" style="margin-top: 0">
            <div class="ui toggle checkbox checked">
                <input type="checkbox" name="fb-publish" id="fb-publish" class="hidden" checked disabled="disabled">
                <label><i class="facebook icon"></i><?php _e('Share on Facebook', 'petition') ?></label>
            </div>
        </div>
    </div>
    <div class="field">
        <button class="ui primary fluid big button submitSign"><i class="write icon"></i><?php _e('I SUPPORT', 'petition') ?></button>
    </div>
    <div class="field">
        <div class="email-notice ui checkbox checked">
          <input type="checkbox" name="email-notice" checked>
          <label><?php esc_html_e('Notify me when new information', 'petition') ?></label>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="respon-message" id="signMessage"></div>
<div class="ui form" id="userSignForm">
    <div class="required field">
        <div class="ui right icon input">
            <input type="text" name="nameSign" id="nameSign" placeholder="<?php _e('Full name', 'petition') ?>">
            <i class="user icon"></i>
        </div>
    </div>
    <div class="required field">
        <div class="ui right icon input">
            <input type="text" name="emailSign" id="emailSign" placeholder="<?php _e('Email', 'petition') ?>">
            <i class="mail icon"></i>
        </div>
    </div>
    <div class="required field">
        <div class="ui right icon input">
            <input type="text" name="addressSign" id="addressSign" placeholder="<?php _e('Address', 'petition') ?>">
            <i class="marker icon"></i>
        </div>
    </div>
    <div class="field">
        <div class="ui right icon large input">
            <input type="text" name="pincodeSign" id="pincodeSign" placeholder="<?php _e('Pincode', 'petition') ?>">
            <i class="location arrow icon"></i>
        </div>
    </div>
    
    <input type="hidden" name="passSign" id="passSign" value="<?php echo wp_generate_password(6, false); ?>">
    <input type="hidden" id="citySign" name="citySign" value="">
    <input type="hidden" id="stateSign" name="stateSign" value="">
    <input type="hidden" id="neighborhoodSign" name="neighborhoodSign" value="">
    <input type="hidden" id="countrySign" name="countrySign" value="">
    <input type="hidden" id="latSign" name="latSign" value="">
    <input type="hidden" id="lngSign" name="lngSign" value="">

    <div class="field">
        <div class="ui pointing below fluid basic label font large">
            <textarea name="sign-comment" class="sign-comment" style="border: 0; font-weight: 400" rows="3" placeholder="<?php _e('I am signing because...', 'petition') ?>"></textarea>
        </div>
        <div class="ui message" style="margin-top: 0">
            <div class="fb-publish ui toggle checkbox checked">
                <input type="checkbox" name="fb-publish" class="hidden" checked disabled="disabled">
                <label><i class="facebook icon"></i><?php _e('Share on Facebook', 'petition') ?></label>
            </div>
        </div>
    </div>
    <div class="field">
        <div class="ui message" style="margin-top: 0">
            <div class="email-notice ui toggle checkbox checked" id="email-notice">
              <input type="checkbox" name="email-notice" checked>
              <label><?php esc_html_e('Notify me when new update', 'petition') ?></label>
            </div>
        </div>
    </div>
    <div class="field">
        <a href="javascript:void(0);" class="ui primary fluid button submitSign"><i class="write icon"></i><?php _e('Sign this petition', 'petition') ?></a>
    </div>
</div>
<?php } ?>