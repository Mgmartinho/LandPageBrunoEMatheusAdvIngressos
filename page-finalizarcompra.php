<?php
/**
 * Template Name: Checkout - Finalizar Compra
 * Template Post Type: page
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

get_header();
?>
<main class="checkout-premium" id="checkout-premium">
    <div class="checkout-premium__shell">
        <header class="checkout-premium__top">
            <div>
                <p class="checkout-premium__eyebrow">Base Criminal</p>
                <h1>Finalizar inscrição</h1>
                <p class="checkout-premium__subtitle">
                    Preencha seus dados e escolha a forma de pagamento para garantir sua participação na imersão.
                </p>
            </div>
            <div class="checkout-premium__trust" aria-label="Informações de segurança da compra">
                <span>Compra segura</span>
                <span>Pagamento protegido</span>
                <span>Ingresso por e-mail</span>
            </div>
        </header>

        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>
<?php
get_footer();
