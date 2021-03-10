<?php

add_action('cmb2_admin_init', 'cintter_register_order_metabox');
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function cintter_register_order_metabox()
{
    /**
     * Sample metabox to demonstrate each field type included
     */
    $cmb_demo = new_cmb2_box(array(
        'id'            => 'order_dados_aluno',
        'title'         => esc_html__('Dados do Aluno', 'cmb2'),
        'object_types'  => array('shop_order'), // Post type
        // 'context'    => 'normal',
        // 'priority'   => 'high',

    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Nome do aluno', 'cmb2'),
        'id'         => 'order_nome_aluno',
        'type'       => 'text'
    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Data de nascimento', 'cmb2'),
        'id'         => 'order_data_nascimento_aluno',
        'type'       => 'text_small',
        'attributes'    => array(
            'class' => 'js-mask-date'
        )
    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Escolaridade', 'cmb2'),
        'id'         => 'order_escolaridade',
        'type'       => 'text'
    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Endereço Gmail', 'cmb2'),
        'id'         => 'order_gmail_aluno',
        'type'       => 'text_email'
    ));
}

add_action('cmb2_admin_init', 'cintter_register_theme_options_metabox');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function cintter_register_theme_options_metabox()
{

    /**
     * Registers options page menu item and form.
     */
    $cmb_options = new_cmb2_box(array(
        'id'           => 'cintter_tooltip_options_page',
        'title'        => esc_html__('Configuração Tooltip', 'cintter'),
        'object_types' => array('options-page'),

        /*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

        'option_key'      => 'cintter_tooltip_options', // The option key and admin menu page slug.
        'icon_url'        => 'dashicons-warning', // Menu icon. Only applicable if 'parent_slug' is left empty.
        // 'menu_title'              => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
        // 'parent_slug'             => 'themes.php', // Make options page a submenu item of the themes menu.
        // 'capability'              => 'manage_options', // Cap required to view options-page.
        // 'position'                => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
        // 'admin_menu_hook'         => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
        // 'priority'                => 10, // Define the page-registration admin menu hook priority.
        // 'display_cb'              => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
        // 'save_button'             => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
        // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
        // 'message_cb'              => 'cintter_options_page_message_callback',
        // 'tab_group'               => '', // Tab-group identifier, enables options page tab navigation.
        // 'tab_title'               => null, // Falls back to 'title' (above).
        // 'autoload'                => true, // Defaults to true, the options-page option will be autloaded.
    ));

    /**
     * Options fields ids only need
     * to be unique within this box.
     * Prefix is not needed.
     */

    $cmb_options->add_field(array(
        'name'    => esc_html__('Texto de explicação do campo "Data de nascimento do aluno"', 'cintter'),
        'id'      => 'tooltip_text_data_nascimento_aluno',
        'type'    => 'text',
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Texto de explicação do campo "Escolaridade"', 'cintter'),
        'id'      => 'tooltip_text_escolaridade',
        'type'    => 'text',
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Texto de explicação do campo "Gmail do aluno"', 'cintter'),
        'id'      => 'tooltip_text_gmail_aluno',
        'type'    => 'text',
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Texto de explicação do campo "Endereço"', 'cintter'),
        'id'      => 'tooltip_text_endereco',
        'type'    => 'text',
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Texto de explicação do campo "Endereço de e-mail"', 'cintter'),
        'id'      => 'tooltip_text_endereco_email',
        'type'    => 'text',
    ));
}

function cintter_get_tooltip_text($key = '', $default = false)
{
    if (function_exists('cmb2_get_option')) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option('cintter_tooltip_options', $key, $default);
    }

    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option('cintter_tooltip_options', $default);

    $val = $default;

    if ('all' == $key) {
        $val = $opts;
    } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
        $val = $opts[$key];
    }

    return $val;
}
