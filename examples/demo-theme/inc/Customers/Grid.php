<?php
namespace Customers;;
class Grid extends \AnyData\Grid{
    private $db;
    function __construct($slug) {
        
        $this->db = new Data();
        parent::__construct($slug, 'Customer', 'Customers', ['disableNew']);
    }

    public function get_count() {
        return $this->db->get_count()->total;
    }

    public function get_items($from, $per_page) {
        $ii = $this->db->get_list($per_page, $from);
        return $this->_prepare_items($ii);
    }

    private function _prepare_items($ii) {
        $items = [];
        foreach($ii as $i) {
            $temp = (array)$i;
            $temp['name'] = $temp['first_name'] . ' ' . $temp['last_name'];
            unset($temp['first_name'], $temp['last_name']);
            $items[] = $temp;
        }
        return $items;
    }

    protected function _get_search_by() {
        return [];
    }

    protected function _get_views() {
        return [];
    }

    protected function _get_bulk_actions() {
        $ba =  [
            'export' => 'Export'
        ];
        return $ba;
    }

    protected function _get_actions() {
        $actions = [
            'edit' => ['title' => 'Edit', 'page' => 'customer-form'],
            'delete' => 'Delete',
        ];
        return $actions;
    }


    protected function _get_columns() {
        return [
            'id' => [
                'label' => 'Id',
                'style' => 'width: 15%;',
                'sortable'=>['id', false],
                'uid' => true,
            ],
            'customer_id'  => [
                'label' => 'Customer Id',
            ],
            'email'  => [
                'label' => 'Email',
            ],
            'name'  => [
                'label' => 'Name',
            ],

            'company'  => [
                'label' => 'Company',
            ],

        ];
    }

    protected function _get_filters() {
        return [];
    }


    protected function _process_action($redirect, $params) {
        switch($params['action'])  {
            case 'delete':
                $this->db->delete($params['id']);
                break;
        }
        return $redirect;
    }
    
    // ---

    protected function _process_bulk_action($redirect_to, $action_name, $ids) {
        $ids = array_filter($ids, fn($e) => absint($e) > 0 );
        switch($action_name) {
            case 'export':
                $this->do_export();
        }

        return $redirect_to;
    } 

    // ---

    protected function extra_tablenav($which) {
        if ($which == 'bottom') {
			return;
		}
        echo 'tablenav';
    }

    function do_export() {
        //
    }            

} 

