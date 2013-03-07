<?php defined('INDEX_PAGE') or die('no entrance');

class Read extends Controller {
	
	public function __construct() {
        $this->Item = new Item();
        $this->Card = new Card();
        $this->Sort = new Sort();

        $this->self_conf = get_conf('self_conf');
        $this->sort_conf = $this->Sort->config_sort();
	}

	public function claim($param) {
        $req = $this->_pretreat($param);
        out_put($this->_format($this->Item->get_items(2,$req)));
	}

    public function find($param) {
        $req = $this->_pretreat($param);
        out_put($this->_format($this->Item->get_items(1,$req)));
    }

    public function card($param) {
        $page = isset($param['page']) ? $param['page'] : 1;
        $num = $page < 1 ? $this->self_conf['index_cards'] : $this->self_conf['cards_per_page'];
        out_put($this->_format($this->Card->get_card($num)));
    }

    public function catalog() {
        out_put($this->Sort->list_sort());
    }

    public function admin() {
        $login_name = isset($_POST['login_name']) ? $_POST['login_name'] : null;
        $login_psw = isset($_POST['login_psw']) ? $_POST['login_psw'] : null;
        $safe_code = isset($_POST['safe_code']) ? $_POST['safe_code'] : null;
        if ($login_name && $login_psw) {
            $login_psw .= $this->self_conf['salt'];
            $login_psw = sha1($login_psw);

            if(!isset($this->self_conf['admin'][$login_name])) {
                out_put(array(0,"呃，你想黑我么？没这个用户好吧 o_O~"));}
            elseif ($login_psw == $this->self_conf['admin'][$login_name]) {
                out_put(array(1,"登陆成功",$login_psw));
            } else {
                out_put(array(2,"介个密码系错地，仔细想想哈～"));
            }
        }
        elseif ($safe_code) {
            if($user = array_search($safe_code,$this->self_conf['admin'])){
                out_put(array(1,"cookie有效，已经登陆",$user));
            } else {
                out_put(array(0,"警告，别随便拿个cookie来忽悠我"));
            }
        }

    }

    private  function _pretreat($param) {
        $sort = isset($param['sort']) ? array_search($param['sort'],$this->sort_conf) : null;
        isset($param['sort']) && $param['sort'] === "all" && $sort = null;
        ($sort === false) && show_error("Notice: sort 参数错误.<br>\r\n");

        $state = isset($param['state']) ? array_search($param['state'],$this->self_conf['state']) : null;
        isset($param['state']) && $param['state'] === "all" && $state = null;
        ($state === false) && show_error("Notice: state 参数错误.<br>\r\n");

        $page = isset($param['page']) ? (int)$param['page'] : 1;
        $num = $page < 1 ? $this->self_conf['index_items'] : $this->self_conf['items_per_page'];
        $offset = $page > 1 ? ($page-1)*$this->self_conf['items_per_page']+1 : 0;

        return array($sort,$state,$num,$offset);
    }

    private function _format($array) {
        $result = Array();
        foreach($array as $k=>$v) {
            isset($v['id']) && $result[$k]['id']=$v['id'];
            isset($v['stu_id']) && $result[$k]['stu_id']=$v['stu_id'];

            if(isset($v['card_id'])) {
                $result[$k]['card_id']=$v['card_id'];
            } else {
                isset($v['name']) && $result[$k]['name']=$v['name'];
                isset($v['state']) && $result[$k]['state'] = $this->self_conf['state'][$v['state']];
                isset($v['info']) && $result[$k]['info']=$v['info'];
            }

            isset($v['place']) && $result[$k]['place']=$v['place'];
            isset($v['date']) && $result[$k]['date']=date('Y-m-d',$v['date']);
            isset($v['time']) && $result[$k]['time']=date('Y-m-d',$v['time']);
        }

        return $result;
    }
	
	


}
