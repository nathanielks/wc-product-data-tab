<?php

namespace WC_Product_Data_Tab\Field;

class File extends AbstractField {

  public function outputHtml(){

    global $post;

    $attachment = $this->getAttachmentData($post->ID, $this->config->meta_key);
    $preview = (is_null($attachment['src'])) ? $attachment['icon'] : $attachment['src'];
?>
    <p class="form-field">
      <label for="<?php echo $this->config->meta_key; ?>"><?php echo $this->config->label; ?>:</label>
      <span id="<?php echo $this->config->id; ?>_image_preview" style="width: 50px; height: 50px;float:left;display:block;">
        <img class="preview-image" style="max-width:100%;height:auto;" src="<?php echo $preview; ?>">
      </span>
      <input type="hidden" class="form-field-input" name="<?php echo $this->config->meta_key; ?>" id="<?php echo $this->config->meta_key; ?>" value="<?php echo $attachment['id']; ?>" />
      <input type="button" data-uploader_title="Upload <?php $this->config->label; ?>" data-uploader_button_text="Attach Image" class="upload_image_button upload_button button" value="<?php _e('Upload a file', 'woocommerce'); ?>" />
    </p>
<?php

  }

}
