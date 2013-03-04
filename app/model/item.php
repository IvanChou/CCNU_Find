<?php

class Item extends Model {

	public function get_row($id ='1') {
		$where = 'id='.(int)$id;
		return $this->db->select_line('*', $where);
	}

    public function get_items($type, $array, $other = null) {
        $this->db->set_table("cf_info");

        $where = "`type`=$type";
        $where .= $array[0] ? " AND `sort`=$array[0]" : " AND NOT (`sort`=1)";
        ($array[1] !== null) && $where .= " AND `state`=$array[1]";
        $where .= " ORDER BY `id` DESC";
        $where .= " LIMIT $array[2]";
        $array[3] && $where .= " OFFSET $array[3]";

        return $this->db->select('*', $where);
    }

    public function get_item($id = null) {
        if($id === null) return false;

        $this->db->set_table("cf_info");
        $where = "`id`=$id";
        return $this->db->select('*', $where);
    }

    public function set_item($id = null,$state = null) {
        if($state === null) return false;
        if(!self::get_item($id)) return false;

        $where = "`id`=$id";
        $data = array('state'=>$state);

        return($this->db->update($data, $where));
    }

    public function del_item($id = null) {
        if(!self::get_item($id)) return false;

        $where = "`id`=$id";
        return($this->db->delete($where));
    }
}
