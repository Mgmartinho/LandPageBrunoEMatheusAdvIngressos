<?php
declare(strict_types=1);

/**
 * Template Name: Landing Page Palestra
 * Description: Landing page para captação de leads e venda de palestra.
 */

$ticketProductId = 18;
$ticketProduct = function_exists("wc_get_product") ? wc_get_product($ticketProductId) : false;
$paymentUnlocked = $ticketProduct instanceof WC_Product && $ticketProduct->is_purchasable() && $ticketProduct->is_in_stock();

// PORCENTAGEM MANUAL DA FAIXA DE ALERTA (use um valor de 0 a 100).
// Exemplo: 50 significa que 50% das vagas já foram vendidas.
$ticketSoldPercentage = 47;
$ticketSoldPercentage = max(0, min(100, (int) $ticketSoldPercentage));
$paymentLink = $paymentUnlocked
    ? add_query_arg(["add-to-cart" => (string) $ticketProduct->get_id(), "quantity" => "1"], basecriminal_checkout_url())
    : "#ingresso";
$eventWhatsappNumber = preg_replace("/\D+/", "", (string) (getenv("EVENT_WHATSAPP_NUMBER") ?: "+55 11 93940-2802"));
$eventWhatsappMessage = rawurlencode("Olá, gostaria de tirar algumas dúvidas referentes ao curso da Imersão da Base Criminal.");
$eventWhatsappLink = $eventWhatsappNumber !== "" ? "https://wa.me/" . $eventWhatsappNumber . "?text=" . $eventWhatsappMessage : "#ingresso";

get_header();
?>

<div class="event-page">
    <header
        class="event-hero"
        id="topo"
        style="--hero-bg-desktop: url('<?php echo esc_url(get_template_directory_uri() . '/imgs/backgroundAtt.jpg'); ?>'); --hero-bg-mobile: url('<?php echo esc_url(get_template_directory_uri() . '/imgs/BanerBrunoMatheus.jpg'); ?>');"
    >
        <div class="event-shell">
            <nav class="event-nav" aria-label="Navegação principal">
                <a class="event-brand" href="#topo" aria-label="Base Criminal - início">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Logo-transparent.png'); ?>" alt="Base Criminal">
                </a>
                <div class="event-nav__actions">
                    <a class="nav-consult" href="<?php echo esc_url(home_url('/?page_id=57')); ?>">Consultar meu ingresso</a>
                    <a class="nav-cta" href="#ingresso">Garantir ingresso <span aria-hidden="true">&#8599;</span></a>
                </div>
            </nav>

            <div class="hero-layout">
                <div class="event-hero-copy">
                    <p class="event-kicker"><span class="pulse-dot"></span> Imersão presencial para criminalistas</p>
                    <h1>Do flagrante <em>à liberdade</em></h1>
                    <p class="hero-subtitle">A estratégia que sustenta uma defesa criminal segura nas primeiras horas.</p>
                    <div class="hero-actions">
                        <a class="event-button" href="#ingresso">Quero minha vaga <span aria-hidden="true">&#8594;</span></a>
                        <a class="hero-link" href="#programa">Conhecer a imersão <span aria-hidden="true">&#8595;</span></a>
                    </div>
                </div>
                <!-- <aside class="hero-event-card" aria-label="Informações do evento">
                    <span class="card-label">Próxima edição</span>
                    <strong>26<span>SET</span></strong>
                    <p>Sábado<br>09h às 18h</p>
                    <div class="card-rule"></div>
                    <p class="event-location">Vila Andrade<br><span>São Paulo, SP</span></p>
                </aside> -->
            </div>
            <div class="hero-proof" >
                <p><strong>03 Out 2026</strong><span>Sábado das 9h às 18h</span></p>
                <p><strong>Vagas limitadas</strong><span>Turma intimista para uma experiência real de troca</span></p>
                <p><strong>100% presencial</strong><span>Um dia inteiro para quem quer sair do lugar comum</span></p>
            </div>
        </div>
    </header>

    <aside class="event-stock-alert" aria-label="Disponibilidade de ingressos">
        <div class="event-shell event-stock-alert__inner">
            <div class="event-stock-alert__message">
                <span class="event-stock-alert__icon" aria-hidden="true">!</span>
                <p><strong>Não perca a chance.</strong> <?php echo esc_html((string) $ticketSoldPercentage); ?>% das vagas já foram preenchidas.</p>
            </div>
            <div class="event-stock-alert__progress" aria-hidden="true">
                <span style="width: <?php echo esc_attr((string) $ticketSoldPercentage); ?>%;"></span>
            </div>
        </div>
    </aside>

    <main>
    
        <section class="event-section manifest-section">

            <div class="event-shell manifest-grid">
                <p class="vertical-label">Base Criminal 2026</p>
                <div>
                    <h2 class="event-kicker">Não é sobre decorar procedimentos</h2>
                    <h2 class="event-heading">A defesa não começa no processo.<br><span>Ela começa na decisão.</span></h2>
                </div>
                <div class="manifest-copy">
                    <p>Nas primeiras horas, cada escolha muda o rumo de uma história. Esta imersão foi desenhada para quem quer construir estratégia com leitura de caso, presença e técnica.</p>
                    <a class="text-link" href="#programa">Entenda a experiência <span aria-hidden="true">&#8594;</span></a>
                </div>
            </div>
        </section>

        <section class="event-section program-section" id="programa">
            <div class="event-shell">
                <div class="section-intro">
                    <div>
                        <p class="event-kicker">O que você vai dominar</p>
                        <h2 class="event-heading">Menos teoria solta.<br><span>Mais critério para agir.</span></h2>
                    </div>
                    <p>Uma jornada que acompanha o momento em que a defesa mais precisa ser precisa.</p>
                </div>
                <div class="program-grid">
                    <!-- <article class="program-item featured">
                        <span class="program-number">01</span>
                        <h3>O flagrante como ponto de partida</h3>
                        <p>Leitura imediata do caso, coleta de informações e construção dos primeiros movimentos da defesa.</p>
                    </article>
                    <article class="program-item">
                        <span class="program-number">02</span>
                        <h3>Estratégia que se sustenta</h3>
                        <p>Como transformar fatos, documentos e contexto em uma linha defensiva consistente.</p>
                    </article>
                   
                    <article class="program-item">
                        <span class="program-number">04</span>
                        <h3>Liberdade e pedidos urgentes</h3>
                        <p>Estrutura, argumentação e tomada de decisão para os primeiros pedidos de liberdade.</p>
                    </article>
                    <article class="program-item">
                        <span class="program-number">05</span>
                        <h3>Modelos, repertório e rede</h3>
                        <p>Materiais de apoio e conversas francas com quem vive a prática criminal todos os dias.</p>
                    </article> -->
 <!-- IMAGE ITEMS -->
                     <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Delegacia_Foto_Entrada.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div>
                            <span class="program-number">01</span><h3>O flagrante como ponto de partida</h3>
                        </div>
                    </article>
                    <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Audiencia.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div><span class="program-number">02</span><h3>Estratégia que se sustenta</h3></div>
                    </article>
                    <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Forum.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div><span class="program-number">03</span><h3>Levantamento de provas</h3></div>
                    </article>
                    <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Grade.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div><span class="program-number">04</span><h3>Liberdade e pedidos urgentes</h3></div>
                    </article>
                    <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Delegacia_Cela.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div><span class="program-number">05</span><h3>Modelos, repertório e rede</h3></div>
                    </article>
                    <article class="program-item image-item">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/Prisao_Algema.jpeg'); ?>
                        " alt="Ambiente de audiência">
                        <div><span class="program-number">06</span><h3>Defesa</h3></div>
                    </article>
                    
                </div>
            </div>
        </section>

        <section class="event-cronograma" >
            <div class="event-shell timeline-layout" >
                <div class="timeline-heading">
                    <p class="event-kicker">03 de outubro, sábado</p>
                    <h2 class="event-heading">Um dia para sair com outra <span>forma de enxergar o caso.</span></h2>
                </div>
                <ol class="schedule-list">
                    <li><time>9h</time><p><strong>Chegada e credenciamento</strong>
                    <span>Recepção, boas-vindas e conexões iniciais.</span></p>
</li>
                    <li><time>9h30</time><p><strong>Início da imersão</strong><span>Da abordagem à construção da estratégia</span></p></li>
                    <li><time>12h30</time><p><strong>Pausa para o almoço</strong><span></span></p></li>
                    <li><time>14h</time><p><strong>Retorno da imersão</strong><span>Audiência, liberdade e simulações práticas</span></p></li>
                    <li><time>18h</time><p><strong>Encerramento</strong><span></span></p></li>
                </ol>
                <aside class="location-panel">
                    <span class="card-label">Onde estaremos</span>
                    <h3>Vila Andrade</h3>
                    <p>Av. Giovanni Gronchi, 6195<br> São Paulo, SP</p>
                    <a href="https://www.google.com/maps/search/?api=1&query=Av.+Giovanni+Gronchi,+6195,+Sao+Paulo" target="_blank" rel="noopener">Abrir no mapa <span aria-hidden="true">&#8599;</span></a>
                </aside>
            </div>
        </section>

        <section class="event-section speakers-section">
            <div class="event-shell">
                <div class="section-intro speaker-intro">
                    <div>
                        <p class="event-kicker">Quem conduz a imersão</p>
                        <h2 class="event-heading">Vivência de quem está <span>na linha de frente.</span></h2>
                    </div>
                    <p>Dois profissionais que transformam repertório de campo em uma conversa franca, aplicável e sem atalhos.</p>
                </div>
                <div class="speaker-grid">
                    <article class="speaker-card">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/BrunoSantana.jpeg'); ?>" alt="Dr. Bruno Santana">
                        <div class="speaker-card-content"><span class="speaker-role">Estratégia e defesa de urgência</span><h3>Dr. Bruno<br>Santana</h3>
                        <p>Advogado criminalista, com experiência em flagrantes, audiências de custódia e pedidos de liberdade.</p></div>
                    </article>
                    <article class="speaker-card speaker-card-offset">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/imgs/matheusBaner.jpeg'); ?>" alt="Dr. Matheus Alexandre">
                        <div class="speaker-card-content"><span class="speaker-role">Prática e formação profissional</span><h3>Dr. Matheus<br>Alexandre</h3>
                        <p>Advogado criminalista especializado em Jurisprudência penal do STF e STJ e em defesa criminal desde o primeiro momento.</p></div>
                    </article>
                </div>
            </div>
        </section>

        <section class="event-price" id="ingresso">
            <div class="event-shell offer-layout">
                <div class="offer-copy">
                    <p class="event-kicker">Turma limitada</p>
                    <h2 class="event-heading">Uma experiência que continua <span>na sua próxima atuação.</span></h2>
                    <p>Garanta sua presença em um encontro feito para mudar o nível da sua prática criminal.</p>
                </div>
                <div class="ticket-box">
                    <div class="ticket-top"><span>Imersão Base Criminal</span><strong>Presencial</strong></div>
                    <p class="ticket-price">R$ 397<small>,00</small></p>
                    <ul class="ticket-list">
                        <li><details><summary>Imersão presencial intensiva</summary><p>Um dia inteiro de conteúdo prático para elevar o nível da sua atuação criminal.</p></details></li>
                        <li><details><summary>Proximidade e acesso direto aos palestrantes</summary><p>Canal aberto para tirar dúvidas e trocar experiências de perto.</p></details></li>
                        <li><details><summary>Networking de alto impacto</summary><p>Conexão estratégica com advogados e estudantes para futuras parcerias e indicações.</p></details></li>
                        <li><details><summary>Material exclusivo e personalizado</summary><p>Ferramentas e conteúdos criados para você acompanhar o evento e aplicar na prática.</p></details></li>
                        <li><details><summary>Brindes especiais</summary><p>Exclusivo para os participantes do evento.</p></details></li>
                        <li><details><summary>Certificado oficial de participação</summary><p>Comprovação que fortalece seu posicionamento no mercado e currículo.</p></details></li>
                    </ul>
                    <?php if ($paymentUnlocked): ?>
                        <a class="event-button" href="<?php echo esc_url($paymentLink); ?>">Garantir meu ingresso <span aria-hidden="true">&#8594;</span></a>
                    <?php else: ?>
                        <p class="event-message">As vagas para esta imersão estão esgotadas.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="event-section faq-section">
            <div class="event-shell faq-layout">
                <div><p class="event-kicker">Perguntas Frequentes (FAQ)</p><h2 class="event-heading">O que você precisa saber sobre este <span>evento.</span></h2></div>
                <div class="event-faq">
                    <details open><summary>Qual é o tema principal da imersão?</summary><p>O tema é "Do flagrante à liberdade: estratégia e atuação nas primeiras horas da defesa criminal". É um treinamento 100% prático focado nas etapas decisivas e de maior impacto da advocacia criminal.</p></details>
                    <details><summary>Quando e onde será o evento?</summary><p>A imersão acontecerá no dia 03 de outubro, das 9h às 18h, na Av. Giovanni Gronchi, 6195 - Vila Andrade, São Paulo/SP.</p></details>
                    <details><summary>Para quem é esta imersão?</summary><p>O evento é direcionado para estudantes de Direito e advogados que buscam mais conhecimento para ingressar na área criminal e querem aprender exatamente o que é aplicado na prática.</p></details>
                    <details><summary>O que está incluso no meu ingresso?</summary><p>Seu ingresso garante acesso completo à imersão (9h às 18h), material de apoio personalizado, brindes, certificado digital de participação e espaço dedicado a networking de alto nível.</p></details>
                    <details><summary>Não moro em SP ou não posso ir presencialmente. Haverá transmissão on-line ou gravação?</summary><p>Esta será uma experiência 100% presencial para garantir a dinâmica de networking, troca de experiências e proximidade total com os palestrantes.</p></details>
                    <details><summary>Como funciona a emissão e a carga horária do certificado?</summary><p>Todos os participantes receberão um certificado digital de 9 horas após a realização do evento.</p></details>
                    <details><summary>Comprei meu ingresso e não vou conseguir ir, posso transferir para outra pessoa?</summary><p>Sim, você pode transferir o seu ingresso. Qualquer dúvida, basta entrar em contato com a nossa equipe pelo botão do WhatsApp disponível aqui na página.</p></details>
                </div>
            </div>
        </section>
    </main>

    <footer class="event-footer"><span>Base Criminal</span> Formação prática para uma defesa que chega antes.</footer>
</div>
<a class="whatsapp-float" href="<?php echo esc_url($eventWhatsappLink); ?>" aria-label="Falar sobre o evento pelo WhatsApp" target="_blank" rel="noopener"><img class="whatsapp-float-icon" src="<?php echo esc_url(get_template_directory_uri() . '/imgs/whatsapp.jpg'); ?>" alt=""></a>
<?php get_footer(); ?>