<?php
/**
 * Author: xworm
 * Date: 13-3-3
 * Time: 下午9:06
 */

class Sort extends Model {

    public function list_sort() {
        $this->db->set_table("cf_sort");
        $sorts = $this->db->select('*');
        $sorts[0]['sort_name'] === "一卡通" && array_shift($sorts); // 第一个是 一卡通 ，排除
        return($sorts);
    }

    public function config_sort() {
        $sorts = $this->list_sort();
        $sort_conf = array();
        foreach($sorts as $k => $v ) {
            $sort_conf[$v['id']] = $v['sort_code'];
        }
        return($sort_conf);
    }

    public function change_sort($id, $name = null , $code = null) {
        if($name === null && $code === null) return false;
        $this->db->set_table("cf_sort");

        //理应检测 $id ,此处忽略...
        $where = "`id`=$id";
        $data = array();
        $name && $data['sort_name'] = $name;
        $code && $data['sort_code'] = $code;

        return($this->db->update($data, $where));

    }
}