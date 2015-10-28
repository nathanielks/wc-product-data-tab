<?php

namespace WC_Product_Data_Tab;

class Tab {

	protected $config;

	/*
	 * $config = array(
	 *		'id' => 'example_id',
	 *		'title' => 'Example Title',
	 * );
	 */
	public function __construct($config){
		if(is_array($config)){
			$config = (object) $config;
		}
		$this->config = $config;
	}

	public function load(){
    add_action('woocommerce_product_write_panel_tabs', array($this, 'outputTabHtml'));
    add_action('woocommerce_product_write_panels', array($this, 'outputPanelHtml'));
    $this->eachFields(function($field){
      add_action( 'woocommerce_process_product_meta_simple', array($field, 'processMeta'), 10, 1);
    });
	}

  public function outputTabHtml(){
    $classes = implode(' ', $this->getTabClasses());
    $target = $this->getPanelId();
    $title = $this->config->title;
		echo "<li class=\"$classes\"><a href=\"#$target\">$title</a></li>";
	}

  public function outputPanelHtml(){
    $panelClasses = implode(' ', $this->getPanelClasses());
?>
  <div id="<?php echo $this->getPanelId(); ?>" class="<?php echo $panelClasses; ?>">
<?php
    $this->eachFields(function($field){
      $field->outputHtml();
    });
?>
  </div><!-- /#<?php echo $this->getPanelId(); ?> -->
<?php
  }

  public function getTabClasses(){
    $classes = array();
    if(property_exists($this->config, 'classes')){
      $classes = $this->config->classes;
    }

    $classes[] = $this->config->id;
    $classes[] = $this->config->id . "_tab";

    return $classes;
  }

  public function getPanelClasses(){
    $classes = array('panel', 'woocommerce_options_panel', 'wc_product_data_tab_panel');
    return $classes;
  }

  public function getPanelId(){
    return $this->config->id . '_panel';
  }

  protected function eachFields($function){
    if(property_exists($this->config, 'fields') && is_array($this->config->fields)){
      foreach($this->config->fields as $field){
        $function($field);
      }
    }
  }

}
