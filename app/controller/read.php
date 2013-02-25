<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
		$this->Info = new Info();
        $this->Card = new Card();
	}

	public function claim($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? 5 : 10;
        echo json_encode($this->_format($this->Info->get_claim($num)));
	}

    public function find($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? 5 : 10;
        echo json_encode($this->_format($this->Info->get_find($num)));
    }

    public function card($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? 8 : 20;
        echo json_encode($this->_format($this->Card->get_card($num)));
    }

    private function _format($array) {
        $result = Array();
        foreach($array as $k=>$v) {
            isset($v['id']) && $result[$k]['id']=$v['id'];

            if(isset($v['card_id'])) {
                $result[$k]['card_id']=$v['card_id'];
            } else {
                isset($v['name']) && $result[$k]['name']=$v['name'];
                if(isset($v['state'])) {
                    switch ($v['state']){
                        case 0 : $result[$k]['state'] = "process";
                            break;
                        case 1 : $result[$k]['state'] = "success";
                            break;
                        case -1 : $result[$k]['state'] = "locked";
                            break;
                    }
                }
                isset($v['info']) && $result[$k]['info']=$v['info'];
            }

            isset($v['place']) && $result[$k]['place']=$v['place'];
            isset($v['date']) && $result[$k]['date']=date('Y-m-d',$v['date']);
            //isset($v['time']) && $result[$k]['time']=date('Y-m-d h:i:s',$v['time']);
        }

        return $result;
    }
	
	


}
