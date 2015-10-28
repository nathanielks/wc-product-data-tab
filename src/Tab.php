<?php

namespace WC_Product_Data_Tab;

class Tab {

	protected $config;

	/*
	 * $config = array(
	 *		'title' => 'Example Title',
	 *		'id' => 'example_id'
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
	}

  public function outputTabHtml(){
    $classes = implode(' ', $this->getClasses());
    $target = $this->config->id;
    $title = $this->config->title;
		echo "<li class=\"$classes\"><a href=\"#$target\">$title</a></li>";
	}

  public function getClasses(){
    $classes = array();
    if(property_exists($this->config, 'classes')){
      $classes = $this->config->classes;
    }

    $classes[] = $this->config->id;
    $classes[] = $this->config->id . "_tab";

    return $classes;
  }

}
