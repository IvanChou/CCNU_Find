<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
		$this->Info = new Info();
        $this->Card = new Card();

        $this->self_conf = get_conf('self_conf');
	}

	public function claim($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? $this->self_conf['index_claims'] : $this->self_conf['claims_per_page'];
        echo json_encode($this->_format($this->Info->get_claim($num)));
	}

    public function find($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? $this->self_conf['index_finds'] : $this->self_conf['finds_per_page'];
        echo json_encode($this->_format($this->Info->get_find($num)));
    }

    public function card($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? $this->self_conf['index_cards'] : $this->self_conf['cards_per_page'];
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
                isset($v['state']) && $result[$k]['state'] = $this->self_conf['state'][$v['state']];
                isset($v['info']) && $result[$k]['info']=$v['info'];
            }

            isset($v['place']) && $result[$k]['place']=$v['place'];
            isset($v['date']) && $result[$k]['date']=date('Y-m-d',$v['date']);
            //isset($v['time']) && $result[$k]['time']=date('Y-m-d h:i:s',$v['time']);
        }

        return $result;
    }
	
	


}
