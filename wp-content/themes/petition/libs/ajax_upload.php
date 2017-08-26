<?php
/**
 * @package WordPress
 * @subpackage Petition
 */

if( !function_exists('conikal_upload') ): 
    function conikal_upload() {
        $file_name = 'image-' . wp_generate_password(30, false) . substr($_FILES['aaiu_upload_file']['name'], -4);
        $file = array(
            'name'      => sanitize_text_field($file_name),
            'type'      => sanitize_text_field($_FILES['aaiu_upload_file']['type']),
            'tmp_name'  => sanitize_text_field($_FILES['aaiu_upload_file']['tmp_name']),
            'error'     => sanitize_text_field($_FILES['aaiu_upload_file']['error']),
            'size'      => sanitize_text_field($_FILES['aaiu_upload_file']['size'])
        );
        $file = conikal_fileupload_process($file);
    }
endif;
add_action('wp_ajax_conikal_upload', 'conikal_upload');
add_action('wp_ajax_nopriv_conikal_upload', 'conikal_upload');

if( !function_exists('conikal_delete_file') ): 
    function conikal_delete_file() {
        $attach_id = intval(sanitize_text_field($_POST['attach_id']));
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;
add_action('wp_ajax_conikal_delete_file', 'conikal_delete_file');
add_action('wp_ajax_nopriv_conikal_delete_file', 'conikal_delete_file');

if( !function_exists('conikal_fileupload_process') ): 
    function conikal_fileupload_process($file) {

        $attachment = conikal_handle_file($file);

        if (is_array($attachment)) {
            $html = conikal_get_html($attachment);

            $response = array(
                'success'   => true,
                'html'      => $html,
                'attach'    => $attachment['id']
            );
            echo json_encode($response);
            exit;
        }
        $response = array('success' => false);
        echo json_encode($response);
        exit;
    }
endif;

if( !function_exists('conikal_handle_file') ): 
    function conikal_handle_file($upload_data) {

        $return = false;
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc   =   $uploaded_file['file'];
            $file_name  =   basename($upload_data['name']);
            $file_type  =   wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id      =   wp_insert_attachment($attachment, $file_loc);
            $attach_data    =   wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }

        return $return;
    }
endif;

if( !function_exists('conikal_get_html') ): 
    function conikal_get_html($attachment) {
        $attach_id  =   $attachment['id'];
        $post       =   get_post($attach_id);
        $dir        =   wp_upload_dir();
        $path       =   $dir['baseurl'];
        $file       =    $attachment['data']['file'];
        $html       =   '';
        $html .= $path.'/'.$file; 

        return $html;
    }
endif;

?>