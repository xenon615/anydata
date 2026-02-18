<?php
namespace Customers;

add_action('admin_menu', function() {
    add_menu_page('Customers', 'Customers', 'edit_posts', 'customers', 'dashicons-heart');
    if (function_exists('\AnyData\bootstrap')) {
        \AnyData\bootstrap([
            'what' => 'grid',
            'parent' => 'customers',
            'menu_label' => 'Customers',
            'page_title' => 'Customers',
            'capability' => 'edit_posts',
            'slug' => 'customers-table',
            'class' => __NAMESPACE__ . '\Grid'
        ]);
    }

    admin_submenu_page([
        'parent' => 'customers',
        'menu_label' => 'Customer',
        'page_title' => 'Customer',
        'capability' => 'edit_posts',
        'slug' => 'customer-form',
        'callback' => function($h) {
            $slug = 'customer_form';
            add_filter('form-a_need-a-form', function($forms) use ($slug) {
                return [$slug  => ['remoteLoad' => true]];
            });
            add_action($h, function() use ($slug) {
?>
        <div>
            <form method="POST">
                <div id="<?= $slug; ?>" class="form-a-placeholder"></div>
            </form>
        </div>
<?php
            });
        }
    ]);

    remove_submenu_page('customers','customers');
});



add_filter('form-a_form_load', function($form, $formSlug) {
    if ($formSlug == 'customer_form') {
        parse_str(parse_url(wp_get_referer())['query'], $f);
        $id  =  $f['id'] ?? 0;
        $data = (new Data())->get($id);
        $form = [
            'def' => [
                'title' => 'Customer',
                'remoteSubmit' => true,
                'buttons' => [
                    [
                        'text' => 'Close',
                        'classes' => ['button', 'button-primary','button-large'],
                        'type' => 'submit',
                        'action' => 'close'
                    ],
                    [
                        'text' => 'Update',
                        'classes' => ['button', 'button-primary','button-large'],
                        'type' => 'submit',
                        'action' => 'update'
                    ]

                ],

                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'customer_id',
                        'label' => 'Customer Id',
                        'classes' => ['col-6'],
                        'breakAfter' => true
                    ],
                    [
                        'type' => 'text',
                        'name' => 'email',
                        'label' => 'Email',
                        'classes' => ['col-6'],
                    ],

                    [
                        'type' => 'text',
                        'name' => 'first_name',
                        'label' => 'First Name',
                        'classes' => ['col-6'],
                    ],
                    [
                        'type' => 'text',
                        'name' => 'last_name',
                        'label' => 'Last Name',
                        'classes' => ['col-6'],
                    ],

                    [
                        'type' => 'text',
                        'name' => 'company',
                        'label' => 'company',
                        'classes' => ['col-6'],
                    ],
                ]
            ],
            'data' => $data
        ];

    }
    return $form;
}, 10, 2);

// ---

add_filter('form-a_submit', function($result, $data, $slug) {
    if ($slug == 'customer_form') {
        if ($data['__action'] == 'update') {
            parse_str(parse_url(wp_get_referer())['query'], $f);
            $id  =  $f['id'] ?? 0;
            unset($data['__action']);
            (new Data())->update($data, $id);
            $result['message'] = 'saved successfully!';
        }
        $result['redirectURL'] = admin_url('admin.php?page=customers-table');
    } 
    return $result;
}, 10, 3);
