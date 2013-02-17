<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
		$this->info = new Info();
	}

	public function claim() {
		var_dump($this->_format_time($this->info->get_claim()));
	}

    public function card($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? 5 : 8;
        var_dump($this->_format_time($this->info->get_card($num)));
    }

    private function _format_time($array) {
        foreach($array as $k=>$v) {
            isset($v['date']) && $array[$k]['date']=date('Y-m-d',$v['date']);
            isset($v['time']) && $array[$k]['time']=date('Y-m-d h:i:s',$v['time']);
        }

        return $array;
    }
	
	


}
