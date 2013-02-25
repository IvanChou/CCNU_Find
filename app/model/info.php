<?php defined('INDEX_PAGE') or die('no entrance');

class Info extends Model {

	public function get_row($id='1') {
		$where = 'id='.(int)$id;
		return $this->db->select_line('*', $where);
	}
	
	public function get_claim($num="5", $offset= null) {
        return $this->_get_info(2, $num, $offset);
	}

    public function get_find($num="5", $offset= null) {
        return $this->_get_info(1, $num, $offset);
    }

    private function _get_info($type, $num, $offset) {
        $this->db->set_table("cf_info");
        $where = "`type`=$type AND NOT (`sort`=1) ORDER BY `id` DESC";
        ($num = (int)$num) && $where .= " LIMIT $num";
        $offset && ($offset = (int)$offset) && $where .= " OFFSET $offset";
        return $this->db->select('*', $where);
    }
}
