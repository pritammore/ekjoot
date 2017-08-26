<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

class Contact_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'contact_sidebar', 'description' => 'Your contact information.');
        $control_ops = array('id_base' => 'contact_widget');
        parent::__construct('contact_widget', 'Petition WP Contact', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array(
            'title' => '',
            'organization' => '',
            'phone' => '',
            'mail' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'country' => ''
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $display = '
            <p>
                <label for="' . esc_attr($this->get_field_id('title')) . '">' . __('Title', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . esc_attr($instance['title']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('organization')) . '">' . __('Organization', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('organization')) . '" name="' . esc_attr($this->get_field_name('organization')) . '" value="' . esc_attr($instance['organization']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('phone')) . '">' . __('Phone', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('phone')) . '" name="' . esc_attr($this->get_field_name('phone')) . '" value="' . esc_attr($instance['phone']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('mail')) . '">' . __('Email', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('mail')) . '" name="' . esc_attr($this->get_field_name('mail')) . '" value="' . esc_attr($instance['mail']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('address')) . '">' . __('Address', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('address')) . '" name="' . esc_attr($this->get_field_name('address')) . '" value="' . esc_attr($instance['address']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('city')) . '">' . __('City', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('city')) . '" name="' . esc_attr($this->get_field_name('city')) . '" value="' . esc_attr($instance['city']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('state')) . '">' . __('State/County', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('state')) . '" name="' . esc_attr($this->get_field_name('state')) . '" value="' . esc_attr($instance['state']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('zip')) . '">' . __('Zip code', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('zip')) . '" name="' . esc_attr($this->get_field_name('zip')) . '" value="' . esc_attr($instance['zip']) . '" />
            </p>
            <p>
                <label for="' . esc_attr($this->get_field_id('country')) . '">' . __('Country', 'petition') . ':</label>
                <input type="text" class="widefat" id="' . esc_attr($this->get_field_id('country')) . '" name="' . esc_attr($this->get_field_name('country')) . '" value="' . esc_attr($instance['country']) . '" />
            </p>
        ';

        print $display;
    }


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['organization'] = sanitize_text_field($new_instance['organization']);
        $instance['phone'] = sanitize_text_field($new_instance['phone']);
        $instance['mail'] = sanitize_text_field($new_instance['mail']);
        $instance['address'] = sanitize_text_field($new_instance['address']);
        $instance['city'] = sanitize_text_field($new_instance['city']);
        $instance['state'] = sanitize_text_field($new_instance['state']);
        $instance['zip'] = sanitize_text_field($new_instance['zip']);
        $instance['country'] = sanitize_text_field($new_instance['country']);

        if(function_exists('icl_register_string')) {
            icl_register_string('conikal_contact_widget', 'contact_widget_title', sanitize_text_field($new_instance['title']));
            icl_register_string('conikal_contact_widget', 'contact_widget_organization', sanitize_text_field($new_instance['organization']));
            icl_register_string('conikal_contact_widget', 'contact_widget_phone', sanitize_text_field($new_instance['phone']));
            icl_register_string('conikal_contact_widget', 'contact_widget_mail', sanitize_text_field($new_instance['mail']));
            icl_register_string('conikal_contact_widget', 'contact_widget_address', sanitize_text_field($new_instance['address']));
            icl_register_string('conikal_contact_widget', 'contact_widget_city', sanitize_text_field($new_instance['city']));
            icl_register_string('conikal_contact_widget', 'contact_widget_state', sanitize_text_field($new_instance['state']));
            icl_register_string('conikal_contact_widget', 'contact_widget_zip', sanitize_text_field($new_instance['zip']));
            icl_register_string('conikal_contact_widget', 'contact_widget_country', sanitize_text_field($new_instance['country']));
        }

        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $display = '';
        $title = apply_filters('widget_title', $instance['title']);

        print $before_widget;

        if($title) {
            print $before_title . esc_html($title) . $after_title;
        }

        if($instance['organization']) {
            if(function_exists('icl_t')) {
                $info_organization = icl_t('conikal_contact_widget', 'contact_widget_organization', $instance['organization']);
            } else {
                $info_organization = $instance['organization'];
            }
            $display .= '<h3>' . esc_html($info_organization) . '</h3>';
        }
        $display .= '<div>';
        if($instance['phone']) {
            if(function_exists('icl_t')) {
                $info_phone = icl_t('conikal_contact_widget', 'contact_widget_phone', $instance['phone']);
            } else {
                $info_phone = $instance['phone'];
            }
            $display .= '<div class="font large"><i class="phone icon"></i> ' . esc_html($info_phone) . '</div>';
        }
        if($instance['mail']) {
            if(function_exists('icl_t')) {
                $info_mail = icl_t('conikal_contact_widget', 'contact_widget_phone', $instance['mail']);
            } else {
                $info_mail = $instance['mail'];
            }
            $display .= '<div><i class="mail icon"></i> ' . esc_html($info_mail) . '</div>';
        }
        if($instance['address']) {
            if(function_exists('icl_t')) {
                $info_address = icl_t('conikal_contact_widget', 'contact_widget_address', $instance['address']);
            } else {
                $info_address = $instance['address'];
            }
            $display .= '<i class="marker icon"></i>' . esc_html($info_address) . '<br/>';
        }
        if($instance['city']) {
            if(function_exists('icl_t')) {
                $info_city = icl_t('conikal_contact_widget', 'contact_widget_city', $instance['city']);
            } else {
                $info_city = $instance['city'];
            }
            $display .= esc_html($info_city) . ', ';
        }
        if($instance['state']) {
            if(function_exists('icl_t')) {
                $info_state = icl_t('conikal_contact_widget', 'contact_widget_state', $instance['state']);
            } else {
                $info_state = $instance['state'];
            }
            $display .= esc_html($info_state) . ', ';
        }
        if($instance['zip']) {
            if(function_exists('icl_t')) {
                $info_zip = icl_t('conikal_contact_widget', 'contact_widget_zip', $instance['zip']);
            } else {
                $info_zip = $instance['zip'];
            }
            $display .= esc_html($info_zip) . ', ';
        }
        if($instance['country']) {
            if(function_exists('icl_t')) {
                $info_country = icl_t('conikal_contact_widget', 'contact_widget_country', $instance['country']);
            } else {
                $info_country = $instance['country'];
            }
            $display .= esc_html($info_country);
        }
        $display .= '</div>';

        print $display;
        print $after_widget;
    }

}

?>