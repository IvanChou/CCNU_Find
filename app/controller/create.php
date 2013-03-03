<?php defined('INDEX_PAGE') or die('no entrance');
/**
 * Author: ichou
 * Date: 13-3-1
 * Time: 下午2:50
 */

class Create extends Controller {

    public function __construct() {
        $this->Item = Item::load();
        $this->Card = Card::load();
        $this->Sort = Sort::load();

        var_dump($this->Sort);

        $this->self_conf = get_conf('self_conf');
    }

    public function index() {
        $data = isset($_POST['data']) ? json_decode($_POST['data'],true) : 0;
        out_put($data);
        $this->Sort->config_sort();
    }
}