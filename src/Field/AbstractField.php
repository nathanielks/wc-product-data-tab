<?php

namespace WC_Product_Data_Tab\Field;

abstract class AbstractField {

  protected $config;
  /*
   * $config = array(
   *		'id' => 'example_id',
   *		'title' => 'Example Title',
   *		'meta_key' => '_some_meta_key'
   *		'meta_callback' => 'intval'
   * );
   */

  public function __construct($config){
    if(is_array($config)){
      $config = (object) $config;
    }
    $this->config = $config;
  }

  public function processMeta($post_id){
    if (isset($_POST[$this->config->meta_key])) {
      update_post_meta(
        $post_id,
        $this->config->meta_key,
        call_user_func_array( $this->config->meta_callback, array($_POST[$this->config->meta_key]) )
      );
    }
  }

  protected function getAttachmentData($post_id, $meta_key){
    $attach_id = get_post_meta($post_id, $meta_key, true);
    $attachment = wp_get_attachment_image_src( $attach_id );
    return array(
      'id' => $attach_id,
      'src' => $attachment[0],
      'icon' => wp_mime_type_icon( $attachment_id )
    );
  }
}
