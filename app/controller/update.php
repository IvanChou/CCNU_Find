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
        $this->Conf = new Conf();

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

    public function admin() {
        $old_name = isset($_POST["old"]) ? $_POST["old"] : null;
        $new_name = isset($_POST["new"]) ? $_POST["new"] : null;
        $password = isset($_POST["pwd"]) ? $_POST["pwd"] : null;

        if((!$new_name || $old_name==$new_name) && !$password) {
            out_put(array(0,"没有更改的样子啊，数据丢失吗？"));
        }

        if($password) {
            $password .= $this->self_conf['salt'];
            $password = sha1($password);
        }

        if($this->Conf->update_admin($old_name,$new_name,$password)){
            out_put(array(1,"修改完成，页面刷新ing ～"));
        } else {
            out_put(array(0,"肯定是数据丢失了，重来吧，孩子。"));
        };
    }
}
