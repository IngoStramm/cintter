<?php

// Removes Order Notes Title - Additional Information & Notes Field
add_filter('woocommerce_enable_order_notes_field', '__return_false', 9999);

// Remove Order Notes Field
add_filter('woocommerce_checkout_fields', 'remove_order_notes');

function remove_order_notes($fields)
{
    unset($fields['order']['order_comments']);
    return $fields;
}

// adiciona os campos do aluno e  prepara os campos com tooltip
add_filter('woocommerce_checkout_fields', function ($fields) {

    $fields['billing']['order_title_aluno_section'] = array(
        'label'     => __('Dados do aluno', 'cintter'),
        'required'  => false,
        'class'     => array('form-row-wide', 'cintter-hide-input'),
        'label_class' => array('cintter-fake-title'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 1
    );

    $fields['billing']['order_nome_aluno'] = array(
        'label'     => __('Nome do aluno', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-nome-do-aluno'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 2
    );

    $fields['billing']['order_data_nascimento_aluno'] = array(
        'label'     => __('Data de nascimento', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-data-nascimento-do-aluno', 'js-mask-date'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 3
    );

    $fields['billing']['order_escolaridade'] = array(
        'label'     => __('Escolaridade', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-escolaridade'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 4
    );

    $fields['billing']['order_gmail_aluno'] = array(
        'label'     => __('Endereço Gmail <small>(caso o aluno não tenha uma conta do Gmail clique <a href="https://www.google.com/accounts/NewAccount?hl=pt-br" target="_blank" style="text-decoration: underline;">aqui</a> para criar gratuitamente.)</small>', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-gmail-do-aluno'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 5
    );

    $fields['billing']['order_title_billing_section'] = array(
        'label'     => esc_html__('Billing details', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'cintter-hide-input'),
        'label_class' => array('cintter-fake-title'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 6
    );

    return $fields;
}, 20);

// Salva o aluno no pedido
add_action('woocommerce_checkout_update_order_meta', 'cintter_checkout_field_update_order_meta');

function cintter_checkout_field_update_order_meta($order_id)
{

    if (!empty($_POST['order_nome_aluno']))
        update_post_meta($order_id, 'order_nome_aluno', sanitize_text_field($_POST['order_nome_aluno']));

    if (!empty($_POST['order_data_nascimento_aluno']))
        update_post_meta($order_id, 'order_data_nascimento_aluno', sanitize_text_field($_POST['order_data_nascimento_aluno']));

    if (!empty($_POST['order_escolaridade']))
        update_post_meta($order_id, 'order_escolaridade', sanitize_text_field($_POST['order_escolaridade']));

    if (!empty($_POST['order_gmail_aluno']))
        update_post_meta($order_id, 'order_gmail_aluno', sanitize_text_field($_POST['order_gmail_aluno']));
}

// Exibe dados do aluno no pedido
// add_action('woocommerce_admin_order_data_after_billing_address', 'rec_add_alunos_to_emails_notifications', 10, 1);

// Exibe os dados do aluno na tela do pedido feito para o cliente
add_action('woocommerce_order_details_after_customer_details', 'rec_add_alunos_to_emails_notifications', 10, 1);

// Exibe os dados do aluno no e-mail que o cliente recebe
add_action('woocommerce_email_customer_details', 'rec_add_alunos_to_emails_notifications', 15, 1);

function rec_add_alunos_to_emails_notifications($order)
{

    $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;
    $order_nome_aluno = get_post_meta($order_id, 'order_nome_aluno', true);
    $order_data_nascimento_aluno = get_post_meta($order_id, 'order_data_nascimento_aluno', true);
    $order_escolaridade = get_post_meta($order_id, 'order_escolaridade', true);
    $order_gmail_aluno = get_post_meta($order_id, 'order_gmail_aluno', true);

    if (!$order_nome_aluno && !$order_data_nascimento_aluno && !$order_gmail_aluno && !$order_escolaridade)
        return;

    $output = '';
    $output .= '<div>';
    $output .= '<h3>' . __('Dados do aluno', 'cintter') . '</h3>';

    if ($order_nome_aluno) {
        $output .= '<strong>' . __('Nome do Aluno', 'cintter') . ':</strong> <span class="text">' . $order_nome_aluno . '</span><br />';
    }

    if ($order_data_nascimento_aluno) {
        $output .= '<strong>' . __('Data de nascimento', 'cintter') . ':</strong> <span class="text">' . $order_data_nascimento_aluno . '</span><br />';
    }

    if ($order_escolaridade) {
        $output .= '<strong>' . __('Escolaridade', 'cintter') . ':</strong> <span class="text">' . $order_escolaridade . '</span><br />';
    }

    if ($order_gmail_aluno) {
        $output .= '<strong>' . __('Endereço Gmail', 'cintter') . ':</strong> <span class="text">' . $order_gmail_aluno . '</span><br />';
    }

    $output .= '</div>';
    echo $output;
}

add_action('woocommerce_before_checkout_billing_form', function ($checkout) {
    $tooltip_text_data_nascimento_aluno = cintter_get_tooltip_text('tooltip_text_data_nascimento_aluno');
    $tooltip_text_escolaridade = cintter_get_tooltip_text('tooltip_text_escolaridade');
    $tooltip_text_gmail_aluno = cintter_get_tooltip_text('tooltip_text_gmail_aluno');
    $tooltip_text_endereco = cintter_get_tooltip_text('tooltip_text_endereco');
    $tooltip_text_endereco_email = cintter_get_tooltip_text('tooltip_text_endereco_email');

    if (!$tooltip_text_escolaridade && !$tooltip_text_gmail_aluno && !$tooltip_text_data_nascimento_aluno && !$tooltip_text_endereco && !$tooltip_text_endereco_email)
        return;

    echo '<div id="tooltip-texts">';

    if ($tooltip_text_data_nascimento_aluno) {
        echo '<input type="text" data-tooltip-field="order_data_nascimento_aluno_field" id="tooltip_text_data_nascimento_aluno" value="' . $tooltip_text_data_nascimento_aluno . '" disabled />';
    }

    if ($tooltip_text_escolaridade) {
        echo '<input type="text" data-tooltip-field="order_escolaridade_field" id="tooltip_text_escolaridade" value="' . $tooltip_text_escolaridade . '" disabled />';
    }

    if ($tooltip_text_gmail_aluno) {
        echo '<input type="text" data-tooltip-field="order_gmail_aluno_field" id="tooltip_text_gmail_aluno" value="' . $tooltip_text_gmail_aluno . '" disabled />';
    }

    if ($tooltip_text_endereco) {
        echo '<input type="text" data-tooltip-field="billing_address_1_field" id="tooltip_text_endereco" value="' . $tooltip_text_endereco . '" disabled />';
        echo '<input type="text" data-tooltip-field="shipping_address_1_field" id="tooltip_text_endereco" value="' . $tooltip_text_endereco . '" disabled />';
    }

    if ($tooltip_text_endereco_email) {
        echo '<input type="text" data-tooltip-field="billing_email_field" id="tooltip_text_endereco_email" value="' . $tooltip_text_endereco_email . '" disabled />';
    }

    echo '</div>';
});

// Adiciona os campos customizados à pesquisa do pedido do WooCommerce
// Ref: https://wordpress.stackexchange.com/questions/11758/extending-the-search-context-in-the-admin-list-post-screen

add_filter('posts_join', 'cintter_search_join');
function cintter_search_join($join)
{
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
    if (is_admin() && 'edit.php' === $pagenow && 'shop_order' === $_GET['post_type'] && !empty($_GET['s'])) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

add_filter('posts_where', 'cintter_search_where');
function cintter_search_where($where)
{
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni".
    if (is_admin() && 'edit.php' === $pagenow && 'shop_order' === $_GET['post_type'] && !empty($_GET['s'])) {
        $where = preg_replace(
            "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)",
            $where
        );
    }
    return $where;
}

// assegura que o resultado da pesquisa não será duplicado
add_filter('posts_distinct', 'cintter_search_distinct');
function cintter_search_distinct($where)
{
    global $pagenow;

    if (is_admin() && $pagenow == 'edit.php' && $_GET['post_type'] == 'shop_order' && $_GET['s'] != '') {
        return "DISTINCT";
    }
    return $where;
}
