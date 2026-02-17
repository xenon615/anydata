<?php
namespace AnyData;
class Grid extends \WP_List_Table {
	private static $_instance;
	private $_columns;
	private $_column_styles;
	private $_sortable = [];
	private $_row_actions;
	private $_bulk_actions;
	private $_filters;
	private $_views;
	private $_slug;
	private $_uid_column = '';
	private $_search_by = '';

	public function __construct($params) {

		$this->_columns['cb'] = '<input type="checkbox" />';
		foreach($params['columns'] as $k => $v) {
			if (empty($v['hide'])) {
				$this->_columns[$k] = $v['label'];
			}
			
			$this->_column_styles[$k] = $v['style'];
			if (isset($v['sortable'])) {
				$this->_sortable[$k] = $v['sortable'];
			}
			if (!empty($v['uid'])) {
				$this->_uid_column = $k;
			}
		}
		
		$this->_search_by = $params['search_by'] ?? '';
		
		$this->_row_actions = array_merge(['edit' => 'Edit'], $params['actions'] ?? []);
		$this->_bulk_actions = $params['bulk_actions'] ?? [];
		$this->_filters = $params['filters'] ?? [];
		$this->_views = $params['views'] ?? [];
		$this->_slug = $params['slug'];
        parent::__construct( [
			'singular' => $params['singular'],
			'plural'   =>  $params['plural'],
			'ajax'     => $params['ajax'] ?? false ,
		]);
		if ($this->_uid_column == '') {
			$this->_uid_column = $this->get_primary_column();
		}


		$this->process_bulk_action();
		add_screen_option( 'per_page', [
            'label'   => $params['plural'],
            'default' => 5,
            'option'  => str_replace('-', '_', $this->_slug) . '_per_page'
        ]);

		self::$_instance = $this;
    }

	// ---

	public static function getInstance() {
		return self::$_instance;
	}

	// ---

	public function show() {
		$this->prepare_items();
		$this->print_styles();
		$this->print_wrapper();
	}

	// ---

	private function print_wrapper() {
		$message = '';
?>
	<div class="wrap">
		<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
		<h2><?php echo ucfirst($this->_args['plural']);?>
			<a class="add-new-h2" href="<?php echo admin_url('admin.php?page=' . $this->_slug .'-form&ad-action-nonce=' . wp_create_nonce('add')  );?>">
				<?php echo 'Add new';?>
			</a>
		</h2>
		<p><?php echo $message;?></p>
<?php
			if (!empty($this->_views)) {
				$this->views();
			}
	
?>		
		<form id="<?php echo $this->_slug; ?>-table" method="GET">
			<input type="hidden" name="page" value="<?php echo $this->_slug; ?>"/>
<?php 
			wp_nonce_field('anydata-grid', 'anydata-nonce');
			$this->search_box('Search', 'anydata-search');
			$this->display();
?>
		</form>
	</div>	
<?php
	}

	// ---

	function print_styles() {
		echo '<style>';
		echo 'table.wp-list-table .check-column {width: 1%}';
        foreach($this->_column_styles as $k => $v) {
            echo "table.wp-list-table .column-$k {{$v}}";
        }
        echo '</style>';     

	}

	// ---

	function get_sortable_columns() {
		return $this->_sortable;
	}

	// ---

	function get_columns() {
		return $this->_columns;
	}

	// ---

	function prepare_items() {

		$this->_column_headers = $this->get_column_info();
		$per_page = $this->get_items_per_page(str_replace('-', '_', $this->_slug) . '_per_page', 5);
		if (!empty($this->_list_source)) {
			$total_items = $this->_list_source->get_count();
		} else {
			$total_items = apply_filters('anydata-grid_items_count_' . $this->_slug, 0);
		}
		
		$this->set_pagination_args([
			'total_items' => $total_items,
			'per_page'    => $per_page 
		]);
		$from = $this->get_pagenum();
		if (!empty($this->_list_source)) {
			$this->items = $this->_list_source->get_list();
		} else {
			$this->items = apply_filters('anydata-grid_items_' .  $this->_slug, [] , $from, $per_page);
		}
        
	}

	// ---

	function get_actions($item) {
		$pc = $this->_uid_column;
		$prepared = [];
		foreach($this->_row_actions as $k => $v) {
			$url = 'admin.php?page=' . $this->_slug . '-form' . '&' . $pc . '=' .  $item[$pc];
			if ($k != 'edit') {
				$url .= '&action=' . $k . '&ad-action-nonce=' . wp_create_nonce($k);
			}
			$prepared[$k] = '<a href="' .  admin_url($url)  . '">' . $v .'</a>';
		}
		return $this->row_actions($prepared);
	}

	// ---

	function column_default($item, $column_name) {
		$output = $item[$column_name] ?? '';
		if ($column_name == $this->get_primary_column()) {
			$output = '<strong>' . $output . '</strong>';
			$output .=  $this->get_actions($item);
		}
		return $output;
	}

	// ---

	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="item_ids[]" value="%d" />', $item[$this->_uid_column]
		);
	}

	// ---
	
	protected function extra_tablenav($which) {
		if ($which == 'bottom') {
			return;
		}
		foreach($this->_filters as  $g) {
			echo '<div class="alignleft actions">';
			foreach($g as $name => $f) {
				$current = $_REQUEST[$name] ?? ($f['default'] ?? ''); 
				$fid = '_'. $name;
				if (!empty($f['label'])) {
					echo '&nbsp;<label for="' . $fid . '"><span style="display: inline-block;">'. $f['label'] . '</span></label>&nbsp;';
				}
				if ($f['type'] == 'select') {
					echo '<select  name="' . $name . '" id="' . $fid . '" style="float: none; display: inline-block; vertical-align: middle;">';
					foreach($f['choices'] as $c) {
						echo '<option ' . selected($current, $c['value']) . 'value="' . $c['value']. '">' . $c['label'] . '</option>';
					}
					echo '</select>';
				} else if ($f['type'] == 'date') {
					echo '<input size="10" type="date" id="' . $fid. '"  value="' . ($_REQUEST[$name] ?? '') .  '">';
				}
			}
			echo '</div>';
		}
		submit_button( __( 'Filter' ), '', 'filter_action', false, array( 'id' => 'filter-query-submit' ));	
	}

	// ---

	public function get_bulk_actions() {
		return $this->_bulk_actions;
	}

	// ---

	protected function get_views() {
		$view_links = [];
		$current = $_REQUEST['view'] ?? array_keys($this->_views)[0];
		foreach($this->_views as $k => $v) {
			$view_links[$k] = '<a' . ($current == $k  ? ' class="current"' : '') . ' href="' . admin_url('admin.php?page=' . $this->_slug . '&view=' . $k ) . '">' . $v. '</a>';
		}
		return $view_links;

	}

	// ---

	public function process_bulk_action() {
		$doaction = $this->current_action();
		if ($doaction) {
			$preserved = ['page'];
			foreach($this->_filters as $g) {
				$preserved = array_merge($preserved, array_keys($g));
			}
			$parsed = parse_url(wp_get_referer());
			$diff = [];
			if (isset($parsed['query'])) {
				\parse_str($parsed['query'], $f);
				$diff = array_diff(array_keys($f), $preserved);
			}
			$sendback = remove_query_arg($diff, wp_get_referer());
			$sendback = add_query_arg( 'paged', $this->get_pagenum(), $sendback);
			if (empty($_REQUEST['item_ids'])) {
				$item_ids = [];
			} else {
				$item_ids = array_map('intval', $_REQUEST['item_ids']);
			}

			$sendback = apply_filters('handle_bulk_actions-' . get_current_screen()->id, $sendback, $doaction, $item_ids);
			wp_redirect($sendback);
			exit();
		}
	}

	// ---

	public function search_box( $text, $input_id ) {
		if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
			return;
		}
		$input_id = $input_id . '-search-input';
		if ( ! empty( $_REQUEST['orderby'] ) ) {
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		}
		if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}
		
?>
		
		<p class="search-box">
<?php  	
		if (!empty($this->_search_by)) {
			$s_by = $_REQUEST['s_by'] ?? $this->_search_by['default'];
			echo '<select  name="s_by" id="s_by" style="float: left; display: inline-block; vertical-align: middle;">';
			foreach($this->_search_by['options'] as $k => $v) {
				echo '<option value="' . $k . '"' . selected($k, $s_by) . '>' . $v .'</option>';
			}
			echo '</select>';
		}
?>		
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo $text; ?>:</label>
			<input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" />

			<?php submit_button( $text, '', '', false, array( 'id' => 'search-submit' ) ); ?>
		</p>
<?php
	}
}
