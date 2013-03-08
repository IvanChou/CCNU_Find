<?php defined('INDEX_PAGE') or die('no entrance');
/**
 * Author: ichou
 * Date: 13-3-1
 * Time: 下午3:40
 */

class Update extends Controller {

    public function __construct() {
        $this->Item = new Item();
        $this->Card = new Card();
        $this->Sort = new Sort();

        $this->self_conf = get_conf('self_conf');
    }

    public function index() {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : null;
        $state = isset($_POST['state']) ? array_search($_POST['state'],$this->self_conf['state']) : null;
        $safe_code = isset($_POST["safe_code"]) ? $_POST["safe_code"] : null;
        if($state === null) {
            out_put(array(0,"纳尼，数据错误耶，快刷新页面吧。"));
            return;
        }

        if($this->Item->set_item($id,$state)){
            out_put(array(1,"小Case，秒秒钟就搞定了～"));
        } else {
            out_put(array(0,"页面参数居然有错，刷个新吧，骚年。"));
        }

        return;
    }

    public function sort() {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : null;
        $sort_name = isset($_POST["sort_name"]) ? $_POST["sort_name"] : null;
        $sort_code = isset($_POST["sort_code"]) ? $_POST["sort_code"] : null;

        if($this->Sort->change_sort($id,$sort_name,$sort_code)) {
            out_put(array(1,"小Case啦，秒秒钟就搞定了～"));
        } else {
            out_put(array(0,"哎哟喂，更新失败了耶，重来试试？"));
        }
    }
}
