<?php

add_action('cmb2_admin_init', 'cintter_register_demo_metabox');
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function cintter_register_demo_metabox()
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
        'name'       => esc_html__('Qual ano o aluno está cursando', 'cmb2'),
        'id'         => 'order_ano_curso',
        'type'       => 'text'
    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Gmail do aluno', 'cmb2'),
        'id'         => 'order_gmail_aluno',
        'type'       => 'text_email'
    ));
    $cmb_demo->add_field(array(
        'name'       => esc_html__('Data de nascimento do aluno', 'cmb2'),
        'id'         => 'order_data_nascimento_aluno',
        'type'       => 'text_small',
        'attributes'    => array(
            'class' => 'js-mask-date'
        )
    ));
}