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
        $data = isset($_POST['data']) ? json_decode($_POST['data'],true) : 0;
        out_put($data);
    }
}