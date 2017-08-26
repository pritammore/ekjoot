<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Petition
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
$conikal_appearance_settings = get_option('conikal_appearance_settings','');
$ajax_comment_setting = isset($conikal_appearance_settings['conikal_ajax_comment_field']) ? $conikal_appearance_settings['conikal_ajax_comment_field'] : 'enabled';
$id = get_the_ID();
$commnet_count = wp_count_comments($id);
?>

<?php if ($ajax_comment_setting === 'disabled') { ?>
    <div id="comments" class="comments-area">

        <?php if ( have_comments() ) : ?>
            <h3 class="ui dividing header"><span id="comment-count"><?php echo  conikal_format_number('%!,0i', esc_html($commnet_count->approved)) ?></span> <?php _e('Comments', 'petition') ?></h3>
            <?php conikal_comment_nav(); ?>

            <div class="ui comments" id="comments-list" style="width: 100%">
                <?php
                    wp_list_comments( 'type=all&max_depth=2&callback=conikal_comment_callback' );
                ?>
            </div><!-- .comment-list -->

            <?php conikal_comment_nav(); ?>

        <?php endif; // have_comments() ?>

        <?php
            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'petition'); ?></p>
        <?php endif; ?>

        <?php
            $commenter = wp_get_current_commenter();
            $req = get_option( 'require_name_email' );
            $aria_req = ( $req ? " aria-required='true'" : '' );
            $fields =  array(
              'author' =>
                '<div class="comment-form-author field ' . ( $req ? 'required' : '' ) . '"><label>' . __('Name', 'petition') . '</label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" ' . $aria_req . ' /></div>',

              'email' =>
                '<div class="comment-form-email field ' . ( $req ? 'required' : '' ) . '"><label>' . __('Email', 'petition') . '</label> ' .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                '" ' . $aria_req . ' /></div>',

              'url' =>
                '<div class="comment-form-url field"><label>' . __('Website', 'petition') . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                '" /></div>',
            );
            $comments_args = array(
            'class_form' => 'ui form',
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            // change the title of send button 
            'label_submit'=> __('Submit', 'petition'),
            // change the title of the reply section
            'title_reply'=> __('Write a Reply or Comment', 'petition'),
            // remove "Text or HTML to be displayed after the set of comment fields"
            'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.', 'petition') . ( $req ? __('Required fields are marked *', 'petition') : '' ) . '</p>',
            'comment_notes_after' => '<div class="three fields">',
            // redefine your own textarea (the comment body)
            'comment_field' => '<div class="comment-form-comment field ' . ( $req ? 'required' : '' ) . '"><label>' . __('Comment', 'petition') . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></div>',
            'submit_button' => '</div><div class="field"><input name="%1$s" type="submit" id="%2$s" class="%3$s ui primary submit button" value="%4$s" /></div>'
            );

            comment_form($comments_args);
        ?>
        <?php wp_nonce_field('comment_ajax_nonce', 'securityComment', true); ?>

    </div><!-- .comments-area -->
<?php } else {
    get_template_part('templates/ajax_comments');
} ?>