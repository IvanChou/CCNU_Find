<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
		$this->info = new Info();
	}
		
	// 对 model 层的操作
	public function claim() {
		var_dump($this->info->get_claim());
	}
	
	


}
