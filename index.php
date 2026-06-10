<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

try {
    $counts = request_count_by_status();
    $latestStatement = db()->query('SELECT * FROM help_requests ORDER BY created_at DESC LIMIT 6');
    $latestRequests = $latestStatement->fetchAll();
    $totalRequests = array_sum($counts);
    $urgentStatement = db()->query("SELECT COUNT(*) AS total FROM help_requests WHERE priority = 'hoog' AND status <> 'opgelost'");
    $urgentOpen = (int) $urgentStatement->fetch()['total'];
} catch (Throwable $exception) {
    database_error_page($exception);
}

$activePage = 'home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div>
        <p class="eyebrow">Hackathon casus 1</p>
        <h1>SamenSterk - De Buurt-Helpdesk</h1>
        <p>Een eenvoudige webapplicatie waarmee buurtbewoners hulpvragen kunnen plaatsen en beheren. Het project laat de gevraagde techstack zien: HTML, CSS, JavaScript, PHP en MySQL.</p>
        <div class="hero-actions">
            <a class="button primary" href="create.php">Nieuwe hulpvraag</a>
            <a class="button secondary" href="requests.php">Naar overzicht</a>
        </div>
    </div>

    <aside class="hero-panel" aria-label="Projectinformatie">
        <h2>Projectinformatie</h2>
        <dl class="project-info">
            <div>
                <dt>Concept</dt>
                <dd>SamenSterk</dd>
            </div>
            <div>
                <dt>Onderwerp</dt>
                <dd>Buurtbewoners helpen elkaar</dd>
            </div>
            <div>
                <dt>Techniek</dt>
                <dd>PHP, MySQL, JavaScript</dd>
            </div>
        </dl>
        <div class="hero-meter">
            <span style="width: <?= $totalRequests > 0 ? (int) round(($counts['opgelost'] / $totalRequests) * 100) : 0 ?>%"></span>
        </div>
        <p class="muted"><?= $counts['opgelost'] ?> van <?= $totalRequests ?> hulpvragen staan op opgelost.</p>
    </aside>
</section>

<section class="stats-grid" aria-label="Status overzicht">
    <article class="stat-card">
        <span><?= $counts['open'] ?></span>
        <p>Open hulpvragen</p>
    </article>
    <article class="stat-card">
        <span><?= $counts['in_behandeling'] ?></span>
        <p>In behandeling</p>
    </article>
    <article class="stat-card">
        <span><?= $counts['opgelost'] ?></span>
        <p>Opgelost</p>
    </article>
    <article class="stat-card highlight">
        <span><?= $urgentOpen ?></span>
        <p>Urgent open</p>
    </article>
</section>

<section class="content-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Overzicht</p>
            <h2>Recente hulpvragen</h2>
        </div>
        <a class="button secondary" href="requests.php">Alle hulpvragen</a>
    </div>

    <div class="request-list">
        <?php foreach ($latestRequests as $request): ?>
            <article class="request-card">
                <div class="card-topline">
                    <span class="category"><?= e($request['category']) ?></span>
                    <span class="priority <?= e(priority_class($request['priority'])) ?>"><?= e(priority_label($request['priority'])) ?></span>
                    <span class="status <?= e(status_class($request['status'])) ?>"><?= e(status_label($request['status'])) ?></span>
                </div>
                <h3><?= e($request['title']) ?></h3>
                <p><?= e($request['description']) ?></p>
                <div class="meta">
                    <span><?= e($request['requester_name']) ?></span>
                    <span><?= e($request['location']) ?></span>
                    <span>Voor <?= e(format_date($request['needed_by'])) ?></span>
                </div>
                <a class="text-link" href="request.php?id=<?= (int) $request['id'] ?>">Details bekijken</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="split-section">
    <div class="content-section compact">
        <p class="eyebrow">Werkwijze</p>
        <h2>Gebruikersflow</h2>
        <div class="timeline">
            <div>
                <span>1</span>
                <h3>Vraag plaatsen</h3>
                <p>Een bewoner vult titel, categorie, locatie, prioriteit en contact in.</p>
            </div>
            <div>
                <span>2</span>
                <h3>Vrijwilliger kiest</h3>
                <p>Via zoeken en filters vindt iemand snel een passende hulpvraag.</p>
            </div>
            <div>
                <span>3</span>
                <h3>Status bijwerken</h3>
                <p>De status gaat van open naar in behandeling en daarna opgelost.</p>
            </div>
        </div>
    </div>

    <div class="content-section compact accent-panel">
        <p class="eyebrow">Opdracht</p>
        <h2>Wat is uitgewerkt</h2>
        <ul class="feature-list">
            <li><strong>Create:</strong> nieuwe hulpvragen aanmaken via een formulier.</li>
            <li><strong>Read:</strong> hulpvragen bekijken en filteren.</li>
            <li><strong>Update:</strong> gegevens en status aanpassen.</li>
            <li><strong>Delete:</strong> hulpvragen verwijderen.</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
