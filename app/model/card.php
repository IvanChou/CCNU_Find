<?php

class Card extends Model {

    public function get_card($num="8",$offset= null) {
        $sql = "SELECT * FROM `cf_card` c JOIN `cf_info` i ON i.`id`=c.`info_id` WHERE i.`sort`=1 ORDER BY i.`id` DESC";
        ($num = (int)$num) && $sql .= " LIMIT $num";
        $offset && ($offset = (int)$offset) && $sql .= " OFFSET $offset";
        return $this->db->query2array($sql);
    }
}
