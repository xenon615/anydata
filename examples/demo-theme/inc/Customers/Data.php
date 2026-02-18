<?php
namespace Customers;
class Data {
    private $dbh = null;
    private $q_table = 'customers';

    function __construct() {
        global $wpdb;
        $this->dbh = $wpdb;
        $this->dbh->suppress_errors(true);
        $this->dbh->hide_errors();
    }

      
       
    // ---

    public function delete($id) {
        $this->dbh->delete($this->q_table, ['id' => $id]);
    } 

    // ---

    public function insert($data) {
        $this->dbh->insert($this->q_table, $data);
    }

    // ---
    
    public function get($id) {
        $sql = "select * from {$this->q_table}  where id=$id";
        return $this->dbh->get_row($sql, ARRAY_A);
    }

    // ---

    public function update($data, $id) {
        $this->dbh->update($this->q_table, $data, ['id' => $id]);
    }

    // ---

    public function get_count() {
        $sql = "select count(*) total from $this->q_table";
        return $this->dbh->get_row($sql);
    }

    public function get_list($per_page = 25 , $page_number = 1 ) {
        $offset = ( $page_number - 1 ) * $per_page;
        $sql = "select *  from $this->q_table  ORDER BY id DESC LIMIT $per_page OFFSET $offset";
        return $this->dbh->get_results($sql);
    }
}