<?php
namespace AnyData;
class Grid extends \WP_List_Table {
	private static $_instance;
	private $_columns;
	private $_column_styles;
	private $_sortable = [];
	private $_uid_column = '';
	private $_row_actions;
    protected $_search_by = [];
	protected $_bulk_actions;
	protected $_filters;
	protected $_views;
	public $_slug;
    protected $_singular;
    protected $_plural;
	private $_options = [];

    public function __set($what, $value) {
        if ($what == 'columns') {
            $this->_columns['cb'] = '<input type="checkbox" />';
            foreach($value as $k => $v) {
                if (empty($v['hide'])) {
                    $this->_columns[$k] = $v['label'];
                }
                if (!empty($v['style'])) {
					$this->_column_styles[$k] = $v['style'];
				}
                
                if (isset($v['sortable'])) {
                    $this->_sortable[$k] = $v['sortable'];
                }
                if (!empty($v['uid'])) {
                    $this->_uid_column = $k;
                }
            }
        } else if ($what == 'row_actions') {
            $this->_row_actions = array_merge(['edit' => 'Edit'], $value ?? []);    
        }
    }

    
	public function __construct($slug, $singular, $plural, $options = []) {
		if ( ! empty($_REQUEST['_wp_http_referer']) ) {
			wp_redirect( remove_query_arg( array('_wp_http_referer', 'anydata-nonce', '_wpnonce'), wp_unslash($_SERVER['REQUEST_URI']) ) );
			exit;
   		}

		$this->_slug = $slug;
        $this->_singular = $singular;
        $this->_plural = $plural;
		$this->_options = $options;

        $this->_search_by = $this->_get_search_by();
        $this->columns = $this->_get_columns();
		$this->row_actions = $this->_get_actions();
        $this->_bulk_actions = $this->_get_bulk_actions();
		$this->_filters = $this->_get_filters();
		$this->_views = $this->_get_views();

        parent::__construct([
			'singular' => $this->_singular,
			'plural'   =>  $this->_plural,
			'ajax'     => $params['ajax'] ?? false ,
		]);
		if ($this->_uid_column == '') {
			$this->_uid_column = $this->get_primary_column();
		}
		$this->process_action();
		$this->process_bulk_action();
		add_screen_option( 'per_page', [
            'label'   => $this->_plural,
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
		<h2><?php echo ucfirst($this->_plural);?>
<?php 
		if (!in_array('disableNew', $this->_options)) {
			if (!empty($this->_options['edit_form_slug'])) {
?>
			<a class="add-new-h2" href="<?php echo admin_url('admin.php?page=' . $this->_options['edit_form_slug']);?>">
				<?php echo 'Add new';?>
			</a>

<?php 
			} else {
?>	
			<a class="add-new-h2" href="<?php echo admin_url('admin.php?page=' . $this->_slug .'-form&ad-action-nonce=' . wp_create_nonce('add')  );?>">
				<?php echo 'Add new';?>
			</a>

<?php
			}
		}
?>		

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
		echo 'table.wp-list-table .check-column {width: 2%}';
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
		$total_items = $this->get_count();
		$this->set_pagination_args([
			'total_items' => $total_items,
			'per_page'    => $per_page 
		]);
		$from = $this->get_pagenum();
		$this->items = $this->get_items($from, $per_page);
        
	}

	// ---

	function get_actions($item) {
		$pc = $this->_uid_column;
		$prepared = [];
		foreach($this->_row_actions as $k => $v) {
			if (!is_scalar($v)) {
				$title = $v['title'];
				$page = $v['page'];
			} else {
				$title = $v;
				$page = $this->_slug;
			}

			$url = 'admin.php?page=' . $page . '&' . $pc . '=' .  $item[$pc];
			if ($k != 'edit') {
				$url .= '&action=' . $k . '&ad-action-nonce=' . wp_create_nonce($k);
			}
			$prepared[$k] = '<a href="' .  admin_url($url)  . '">' . $title .'</a>';
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
					echo '<input size="10" name="' . $name . '" type="date" id="' . $fid. '"  value="' . ($_REQUEST[$name] ?? '') .  '">';
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

	public function process_action() {
		if (empty($_REQUEST['action']) || empty($_REQUEST['ad-action-nonce']) || !wp_verify_nonce($_REQUEST['ad-action-nonce'], $_REQUEST['action'])) {
			return ;
		}
		$redirect = remove_query_arg(['action','action2', ], wp_get_referer());

		// $redirect = apply_filters('anydata-grid_action', $redirect, ['id' => absint($_REQUEST['id']), 'action' => $_REQUEST['action']]);
		$redirect = $this->_process_action($redirect, ['id' => absint($_REQUEST['id']), 'action' => $_REQUEST['action']]);

		if (!empty($redirect)) {
			wp_redirect($redirect);
			die();
		}
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

			// $sendback = apply_filters('handle_bulk_actions-' . get_current_screen()->id, $sendback, $doaction, $item_ids);
			$sendback = $this->_process_bulk_action($sendback, $doaction, $item_ids);
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

	public function single_row( $item ) {
		echo '<tr id = "row_' . $item[$this->_uid_column] .  '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

}
