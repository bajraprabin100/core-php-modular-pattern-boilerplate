<?php

require_once '../core/Model.php';

class EventModel extends Model
{
    public function getAllBlogs()
    {
        $stmt = $this->db->query("SELECT * FROM events");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>