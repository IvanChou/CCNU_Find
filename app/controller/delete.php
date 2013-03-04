<?php defined('INDEX_PAGE') or die('no entrance');
/**
 * Author: ichou
 * Date: 13-3-1
 * Time: 下午3:33
 */

class Delete extends Controller {

    public function __construct() {
        $this->Item = new Item();
        $this->Card = new Card();

        $this->self_conf = get_conf('self_conf');
    }

    public function index() {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : null;
        $safe_code = isset($_POST["safe_code"]) ? $_POST["safe_code"] : null;

        if($this->Item->del_item($id)){
            out_put(array(1,"操作成功"));

        } else {
            out_put(array(0,"什么啊，这条信息明明不存在的说，快刷新页面吧。"));
        }

        return;
    }
}
