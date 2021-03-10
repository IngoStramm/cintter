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

// adiciona os campos do aluno
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

    $fields['billing']['order_ano_curso'] = array(
        'label'     => __('Qual ano o aluno está cursando', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-nome-do-curso'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 3
    );

    $fields['billing']['order_gmail_aluno'] = array(
        'label'     => __('Gmail do aluno (caso não tenha um gmail, clique <a href="https://accounts.google.com/signup/v2/webcreateaccount?flowName=GlifWebSignIn&flowEntry=SignUp" target="_blank">aqui</a> para criar gratuitamente)', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-gmail-do-aluno'),
        'clear'     => true,
        'type'        => 'text',
        'priority'    => 4
    );

    $fields['billing']['order_data_nascimento_aluno'] = array(
        'label'     => __('Data de nascimento do aluno', 'cintter'),
        'required'  => true,
        'class'     => array('form-row-wide', 'cintter-data-nascimento-do-aluno', 'js-mask-date'),
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

    if (!empty($_POST['order_ano_curso']))
        update_post_meta($order_id, 'order_ano_curso', sanitize_text_field($_POST['order_ano_curso']));

    if (!empty($_POST['order_gmail_aluno']))
        update_post_meta($order_id, 'order_gmail_aluno', sanitize_text_field($_POST['order_gmail_aluno']));

    if (!empty($_POST['order_data_nascimento_aluno']))
        update_post_meta($order_id, 'order_data_nascimento_aluno', sanitize_text_field($_POST['order_data_nascimento_aluno']));
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
    $order_ano_curso = get_post_meta($order_id, 'order_ano_curso', true);
    $order_gmail_aluno = get_post_meta($order_id, 'order_gmail_aluno', true);
    $order_data_nascimento_aluno = get_post_meta($order_id, 'order_data_nascimento_aluno', true);

    if (!$order_nome_aluno && !$order_ano_curso && !$order_gmail_aluno && !$order_data_nascimento_aluno)
        return;

    $output = '';
    $output .= '<div>';
    $output .= '<h3>' . __('Dados do aluno', 'cintter') . '</h3>';

    if ($order_nome_aluno) {
        $output .= '<strong>' . __('Nome do Aluno', 'cintter') . ':</strong> <span class="text">' . $order_nome_aluno . '</span><br />';
    }

    if ($order_ano_curso) {
        $output .= '<strong>' . __('Ano do aluno', 'cintter') . ':</strong> <span class="text">' . $order_ano_curso . '</span><br />';
    }

    if ($order_gmail_aluno) {
        $output .= '<strong>' . __('Gmail do aluno', 'cintter') . ':</strong> <span class="text">' . $order_gmail_aluno . '</span><br />';
    }

    if ($order_data_nascimento_aluno) {
        $output .= '<strong>' . __('Data de nascimento do aluno', 'cintter') . ':</strong> <span class="text">' . $order_data_nascimento_aluno . '</span><br />';
    }

    $output .= '</div>';
    echo $output;
}
