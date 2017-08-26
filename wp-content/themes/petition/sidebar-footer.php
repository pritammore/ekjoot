<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

if (!is_active_sidebar('first-footer-widget-area') && 
    !is_active_sidebar('second-footer-widget-area') && 
    !is_active_sidebar('third-footer-widget-area') && 
    !is_active_sidebar('fourth-footer-widget-area')) {
        return;
}
?>

<?php if (is_active_sidebar('first-footer-widget-area')) : ?>
    <div class="four wide column">
        <div class="ui link list">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (is_active_sidebar('second-footer-widget-area')) : ?>
    <div class="four wide column">
        <div class="ui link list">
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (is_active_sidebar('third-footer-widget-area')) : ?>
    <div class="four wide column">
        <div class="ui link list">
            <?php dynamic_sidebar('third-footer-widget-area'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (is_active_sidebar('fourth-footer-widget-area')) : ?>
    <div class="four wide column">
        <div class="ui link list">
            <?php dynamic_sidebar('fourth-footer-widget-area'); ?>
        </div>
    </div>
<?php endif; ?>


