<?php defined('INDEX_PAGE') or die('no entrance');

class Info extends Model {

	public function __construct() {
		$this->db = $this->set_db_table("cf_info");
	}

	public function get_row($id='1') {
		$where = 'id='.(int)$id;
		return $this->db->select_line('*', $where);
	}

    public function get_card($num="8",$offset= null) {
        $sql = "SELECT * FROM `cf_info` i JOIN `cf_card` c ON i.`id`=c.`info_id` WHERE i.`sort`=1 ORDER BY i.`id` DESC";
        $num = (int)$num && $sql .= " LIMIT $num";
        $offset && $offset = (int)$offset && $sql .= " OFFSET $offset";
        return $this->db->query2array($sql);
    }
	
	public function get_claim($num="8", $offset= null) {
		$where = "`type`=2 ORDER BY `id` DESC";
		$num = (int)$num && $where .= " LIMIT $num";
		$offset && $offset = (int)$offset && $where .= " OFFSET $offset";
		return $this->db->select('*', $where);
	}
}
