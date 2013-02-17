<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
		$this->info = new Info();
	}

	public function claim() {
		var_dump($this->info->get_claim());
	}

    public function card() {
        var_dump($this->info->get_card());
    }
	
	


}
