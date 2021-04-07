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
        remove_menu_page('tools.php');
        remove_menu_page('qsm_dashboard');
        remove_menu_page('ari-stream-quiz');
    });

    add_action('admin_bar_menu', function ($wp_admin_bar) {
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('new-content');
    }, 999);
}