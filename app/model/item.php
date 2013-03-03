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
        $where .= " ORDER BY `id` DESC";
        $where .= " LIMIT $array[1]";
        $array[2] && $where .= " OFFSET $array[2]";

        return $this->db->select('*', $where);
    }
}
