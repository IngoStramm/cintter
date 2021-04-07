<?php

function cintter_debug($debug)
{
    echo '<pre>';
    var_dump($debug);
    echo '</pre>';
}

function cintter_get_user_role()
{
    if (is_user_logged_in()) :
        $user = wp_get_current_user();
        $roles = (array) $user->roles;
        return $roles[0];
    else :
        return false;
    endif;
}


add_action('init', function () {
    if (cintter_get_user_role() === 'seller')
        cintter_customizacao_vendedor();
});

function cintter_customizacao_vendedor()
{
    add_action('admin_menu', function () {
        global $menu, $submenu;
        // cintter_debug($menu);
        add_menu_page(__('Editar Menus'), __(' Menus '), 'edit_theme_options', 'nav-menus.php', null, 'dashicons-menu', 60);

        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php?post_type=evento');
        remove_menu_page('edit.php?post_type=elementor_library');
        remove_menu_page('edit.php?post_type=qmn_log');
        remove_menu_page('qsm_dashboard');
        remove_menu_page('tools.php');
        remove_menu_page('ari-stream-quiz');

        remove_submenu_page('envato-elements', 'envato-elements#/welcome');
        remove_submenu_page('envato-elements', 'envato-elements#/settings');
        remove_submenu_page('envato-elements', 'envato-elements#/template-kits/free-kits');
        remove_submenu_page('envato-elements', 'envato-elements#/template-kits/free-blocks');
        remove_submenu_page('envato-elements', 'envato-elements#/template-kits/installed-kits');

    });

    add_action('admin_bar_menu', function ($wp_admin_bar) {
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('new-content');
    }, 999);

    // exibe apenas os usuários que forem da role 'customer'
    add_action('pre_user_query', function ($u_query) {

        $current_user = wp_get_current_user();
        if ($current_user->roles[0] != 'seller')
            return;

        global $wpdb;
        $u_query->query_where = str_replace(
            'WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.ID IN (
                SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                    WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                    AND {$wpdb->usermeta}.meta_value LIKE '%customer%')",
            $u_query->query_where
        );
    });


    // previne a edição e exclusão de usuários que não sejam 'customer'
    add_filter('map_meta_cap', function ($caps, $cap, $user_id, $args) {

        switch ($cap) {
            case 'edit_user':
            case 'remove_user':
            case 'promote_user':
                if (isset($args[0]) && $args[0] == $user_id)
                    break;
                elseif (!isset($args[0]))
                    $caps[] = 'do_not_allow';
                $other = new WP_User(absint($args[0]));
                if (!$other->has_cap('customer')) {
                    if (current_user_can('seller'))
                        $caps[] = 'do_not_allow';
                }

                break;
            case 'delete_user':
            case 'delete_users':
                if (!isset($args[0]))
                    break;
                $other = new WP_User(absint($args[0]));
                if (!$other->has_cap('customer')) {
                    if (current_user_can('seller'))
                        $caps[] = 'do_not_allow';
                }

                break;
            default:
                break;
        }
        return $caps;
    }, 10, 4);

    // esconde os filtros por role na aba no topo (para não gerar confusão)
    add_action('admin_head', function () {
        $current_screen = get_current_screen();
        if (empty($current_screen->action) && $current_screen->id == 'users') {
?>
            <style>
                ul.subsubsub {
                    display: none;
                }
            </style>
<?php
        }
    });
}
