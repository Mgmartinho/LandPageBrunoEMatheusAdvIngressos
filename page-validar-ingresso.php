<?php
/**
 * Template Name: Validar Ingresso
 * Template Post Type: page
 */
declare(strict_types=1);
defined('ABSPATH') || exit;

get_header();

$order = null;
$valid_signature = false;

if (isset($_GET['codigo'], $_GET['sig'])) {
    $code = sanitize_text_field(wp_unslash($_GET['codigo']));
    $sig  = sanitize_text_field(wp_unslash($_GET['sig']));
    $candidate = basecriminal_find_order_by_ticket_code($code);
    if ($candidate) {
        $expected = basecriminal_get_validation_signature($candidate);
        if ($expected !== '' && hash_equals($expected, $sig)) {
            $order = $candidate;
            $valid_signature = true;
        }
    }
}
?>
<main class="bc-ticket-page bc-validation-page">
    <div class="bc-ticket-shell bc-ticket-shell--narrow">
        <header class="bc-ticket-page__header">
            <p class="bc-ticket-page__eyebrow">Base Criminal</p>
            <h1>Validação de ingresso</h1>
        </header>

        <?php if ($valid_signature && $order instanceof WC_Order) : ?>
            <?php $status = basecriminal_ticket_status($order); ?>
            <section class="bc-validation-card <?php echo esc_attr($order->is_paid() ? 'is-valid' : 'is-invalid'); ?>">
                <div class="bc-validation-card__icon"><?php echo $order->is_paid() ? '✓' : '!'; ?></div>
                <h2><?php echo esc_html($status['label']); ?></h2>
                <p class="bc-validation-card__code"><?php echo esc_html((string) $order->get_meta(BASECRIMINAL_TICKET_META, true)); ?></p>
                <dl>
                    <div><dt>Participante</dt><dd><?php echo esc_html($order->get_formatted_billing_full_name()); ?></dd></div>
                    <div><dt>Evento</dt><dd><?php echo esc_html(basecriminal_ticket_product_name($order)); ?></dd></div>
                    <div><dt>CPF</dt><dd><?php echo esc_html(basecriminal_mask_cpf(basecriminal_get_order_cpf($order))); ?></dd></div>
                </dl>
                <p class="bc-validation-card__note">A validação consulta o status atual do pedido no WooCommerce.</p>
            </section>
        <?php else : ?>
            <section class="bc-validation-card is-invalid">
                <div class="bc-validation-card__icon">×</div>
                <h2>Ingresso inválido</h2>
                <p>O código informado não pôde ser autenticado.</p>
            </section>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
