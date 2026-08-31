<?php
/**
 * Template Name: Consultar Inscrição
 * Template Post Type: page
 */
declare(strict_types=1);
defined('ABSPATH') || exit;

get_header();

$order = null;
$error = '';

// Link seguro vindo do e-mail: código + chave do pedido.
if (isset($_GET['ingresso'], $_GET['chave'])) {
    $code = sanitize_text_field(wp_unslash($_GET['ingresso']));
    $key  = sanitize_text_field(wp_unslash($_GET['chave']));
    $candidate = basecriminal_find_order_by_ticket_code($code);
    if ($candidate && hash_equals((string) $candidate->get_order_key(), $key)) {
        $order = $candidate;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bc_consulta_nonce'])) {
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bc_consulta_nonce'])), 'bc_consultar_inscricao')) {
        $error = 'Não foi possível validar a solicitação. Atualize a página e tente novamente.';
    } else {
        $cpf   = isset($_POST['cpf']) ? basecriminal_sanitize_cpf(wp_unslash($_POST['cpf'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

        $order = basecriminal_find_order_by_cpf_email($cpf, $email);
        if (!$order) {
            $error = 'Não encontramos uma inscrição com esses dados. Confira o CPF e o e-mail usados na compra.';
        }
    }
}
?>
<main class="bc-ticket-page">
    <div class="bc-ticket-shell">
        <header class="bc-ticket-page__header">
            <p class="bc-ticket-page__eyebrow"><a href="/">Base Criminal</a></p>
            <h1>Consultar inscrição</h1>
            <p>Consulte sua inscrição usando o CPF e o mesmo e-mail informado no pagamento.</p>
        </header>

        <?php if ($order instanceof WC_Order) : ?>
            <?php basecriminal_render_ticket_card($order, true); ?>
            <div class="bc-ticket-actions">
                <button type="button" class="bc-ticket-print" onclick="window.print()">Imprimir comprovante</button>
                <a href="<?php echo esc_url(home_url('?page_id=57')); ?>">Nova consulta</a>
            </div>
        <?php else : ?>
            <section class="bc-ticket-form-card">
                <?php if ($error !== '') : ?>
                    <div class="bc-ticket-alert is-error" role="alert"><?php echo esc_html($error); ?></div>
                <?php endif; ?>
                <form method="post" class="bc-ticket-form" autocomplete="off">
                    <?php wp_nonce_field('bc_consultar_inscricao', 'bc_consulta_nonce'); ?>
                    <label>
                        <span>CPF do participante</span>
                        <input type="text" name="cpf" inputmode="numeric" maxlength="14" placeholder="000.000.000-00" required>
                    </label>
                    <label>
                        <span>E-mail usado na compra</span>
                        <input type="email" name="email" placeholder="voce@email.com" required>
                    </label>
                    <button type="submit">Consultar inscrição</button>
                </form>
                <p class="bc-ticket-form-card__privacy">Por segurança, os dados completos do participante não são exibidos publicamente.</p>
            </section>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>