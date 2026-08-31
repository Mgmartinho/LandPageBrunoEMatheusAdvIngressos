<?php
declare(strict_types=1);

add_theme_support('woocommerce');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

require_once get_template_directory() . '/inc/ingressos.php';

/**
 * Checkout oficial deste projeto.
 * Mantemos o ID em um único ponto para não depender da configuração antiga do WooCommerce.
 */
function basecriminal_checkout_url(): string
{
    $page_id = 35;
    $url = get_permalink($page_id);
    return $url ? $url : (function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/'));
}


/**
 * Assets do tema.
 * O checkout recebe CSS próprio para evitar conflito com a landing page.
 */
function basecriminal_enqueue_assets(): void
{
    $themeVersion = wp_get_theme()->get('Version') ?: '2.0';

    wp_enqueue_style(
        'basecriminal-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'basecriminal-style',
        get_stylesheet_uri(),
        ['basecriminal-fonts'],
        $themeVersion
    );

    wp_enqueue_script(
        'basecriminal-script',
        get_template_directory_uri() . '/script.js',
        [],
        $themeVersion,
        true
    );

    if (is_page_template('page-finalizarcompra.php')) {
        wp_enqueue_style(
            'basecriminal-checkout',
            get_template_directory_uri() . '/checkout.css',
            ['basecriminal-style'],
            $themeVersion
        );
    }

    if (
        is_page_template('page-consultar-inscricao.php') ||
        is_page_template('page-validar-ingresso.php') ||
        (function_exists('is_order_received_page') && is_order_received_page())
    ) {
        wp_enqueue_style(
            'basecriminal-ingressos',
            get_template_directory_uri() . '/assets/css/ingressos.css',
            ['basecriminal-style'],
            $themeVersion
        );
    }
}
add_action('wp_enqueue_scripts', 'basecriminal_enqueue_assets');

/**
 * Processa o add-to-cart da landing antes do template carregar.
 * O carrinho é limpo para que cada clique represente um único ingresso.
 */
function basecriminal_handle_add_to_cart(): void
{
    if (!isset($_GET['add-to-cart']) || !function_exists('WC')) {
        return;
    }

    if (!defined('DONOTCACHEPAGE')) {
        define('DONOTCACHEPAGE', true);
    }

    nocache_headers();

    $requestedProductId = absint(wp_unslash($_GET['add-to-cart']));
    $requestedProduct = wc_get_product($requestedProductId);

    if (!($requestedProduct instanceof WC_Product)) {
        return;
    }

    if (!$requestedProduct->is_purchasable() || !$requestedProduct->is_in_stock()) {
        return;
    }

    if (WC()->cart) {
        WC()->cart->empty_cart();
        WC()->cart->add_to_cart($requestedProductId, 1);
    }

    wp_safe_redirect(basecriminal_checkout_url());
    exit;
}
add_action('template_redirect', 'basecriminal_handle_add_to_cart', 5);
