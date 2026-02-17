<?php
namespace AnyData;
class Form {
	private static $_instance;
    function __construct ($params) {
		$this->params =  $params;
        add_screen_option('layout_columns', array( 'max' => 2, 'default' => 2 ));
		if (isset($this->params['init'])) {
			$this->params['init']();
		}
		self::$_instance = $this;
	
    }

	static function getInstance() {
		return self::$_instance;
	}

    function show () {
		$screen = get_current_screen();
		do_action( 'edit_form_after_editor', false);
?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo $this->params['page_title'];?></h1>
    		<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
			<div id="notice" class="error" style="display:none"'>
				<p></p>
			</div>
			<form id="anydata-form" method="POST">
				<?php wp_nonce_field('anydata-update', 'anydata-nonce'); ?>
				<input type="hidden" name="action" value="update"/>
				<input type="hidden" name="page" value="<?php echo $this->params['slug'];?>"/>
				<input type="hidden" name="id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;?>"/>

				<div class="metabox-holder" id="poststuff">
					<div id="post-body">
						<div id="post-body-content">
                            <?php do_meta_boxes($screen->id,'normal', null); ?>
							<input type="submit" value="Update" id="submit-form" class="button-primary" name="submit">
						</div>
					</div>
				</div>
			</form>
		</div>
<?php 
    }
}