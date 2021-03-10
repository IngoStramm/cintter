<?php

add_action('admin_enqueue_scripts', 'cintter_backend_scripts');
add_action('wp_enqueue_scripts', 'cintter_frontend_scripts');

function cintter_backend_scripts()
{
    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    wp_enqueue_script('cintter-vanilla-masker', CINTTER_URL . 'assets/js/vanilla-masker' . $min . '.js', array(), null, true);
    wp_enqueue_script('cintter-script', CINTTER_URL . 'assets/js/cintter' . $min . '.js', array('cintter-vanilla-masker'), '1.0.0', true);
}

function cintter_frontend_scripts()
{
    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';
    if (empty($min)) :
        wp_enqueue_script('cintter-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    wp_enqueue_script('popper-script', CINTTER_URL . 'assets/js/popper.min.js', array(), null, true);
    wp_enqueue_script('tippy-script', CINTTER_URL . 'assets/js/tippy-bundle.umd.min.js', array(), null, true);
    wp_enqueue_script('cintter-vanilla-masker', CINTTER_URL . 'assets/js/vanilla-masker' . $min . '.js', array(), null, true);
    wp_enqueue_script('cintter-script', CINTTER_URL . 'assets/js/cintter' . $min . '.js', array('popper-script', 'tippy-script', 'cintter-vanilla-masker'), '1.0.0', true);

    wp_enqueue_style('tippy-style', CINTTER_URL . 'assets/css/tippy.css', array(), false, 'all');
    wp_enqueue_style('cintter-style', CINTTER_URL . 'assets/css/cintter.css', array(), false, 'all');
}
