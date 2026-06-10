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

<section class="hero reveal">
    <div class="hero-copy">
        <p class="eyebrow">Hackathon casus 1</p>
        <h1>SamenSterk maakt burenhulp direct zichtbaar.</h1>
        <p>Een kleurrijk en praktisch platform waar buurtbewoners hulpvragen plaatsen, vrijwilligers snel urgentie zien en teams CRUD, filters en statusbeheer demonstreren.</p>
        <div class="hero-actions">
            <a class="button primary" href="create.php">Plaats hulpvraag</a>
            <a class="button secondary" href="requests.php">Bekijk hulpvragen</a>
        </div>
        <div class="trust-row" aria-label="Project kenmerken">
            <span>PHP</span>
            <span>MySQL</span>
            <span>CRUD</span>
            <span>Responsive</span>
        </div>
    </div>
    <aside class="hero-panel" aria-label="Live overzicht">
        <div class="live-badge">Live demo</div>
        <h2>Vandaag in de buurt</h2>
        <div class="hero-meter">
            <span style="width: <?= $totalRequests > 0 ? (int) round(($counts['opgelost'] / $totalRequests) * 100) : 0 ?>%"></span>
        </div>
        <p><?= $counts['opgelost'] ?> van <?= $totalRequests ?> hulpvragen opgelost.</p>
        <ul class="check-list">
            <li>Veilige PDO prepared statements</li>
            <li>Filters met JavaScript auto-submit</li>
            <li>Prioriteit en deadline per aanvraag</li>
        </ul>
    </aside>
</section>

<section class="stats-grid reveal" aria-label="Status overzicht">
    <article class="stat-card">
        <span data-count="<?= $counts['open'] ?>"><?= $counts['open'] ?></span>
        <p>Open hulpvragen</p>
    </article>
    <article class="stat-card">
        <span data-count="<?= $counts['in_behandeling'] ?>"><?= $counts['in_behandeling'] ?></span>
        <p>In behandeling</p>
    </article>
    <article class="stat-card">
        <span data-count="<?= $counts['opgelost'] ?>"><?= $counts['opgelost'] ?></span>
        <p>Opgelost</p>
    </article>
    <article class="stat-card highlight">
        <span data-count="<?= $urgentOpen ?>"><?= $urgentOpen ?></span>
        <p>Urgent open</p>
    </article>
</section>

<section class="content-section reveal">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Nieuwste aanvragen</p>
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

<section class="split-section reveal">
    <div class="content-section compact">
        <p class="eyebrow">Proces</p>
        <h2>Hoe de demo werkt</h2>
        <div class="timeline">
            <div>
                <span>1</span>
                <h3>Vraag plaatsen</h3>
                <p>Een bewoner vult titel, categorie, locatie, prioriteit en contact in.</p>
            </div>
            <div>
                <span>2</span>
                <h3>Vrijwilliger kiest</h3>
                <p>Via filters vindt iemand snel een passende hulpvraag in de buurt.</p>
            </div>
            <div>
                <span>3</span>
                <h3>Status bijwerken</h3>
                <p>De status gaat van open naar in behandeling en daarna opgelost.</p>
            </div>
        </div>
    </div>

    <div class="content-section compact accent-panel">
        <p class="eyebrow">Pitchpunten</p>
        <h2>Waarom dit scoort</h2>
        <ul class="feature-list">
            <li><strong>Maatschappelijke impact:</strong> minder eenzaamheid en meer lokale samenwerking.</li>
            <li><strong>Technisch bewijs:</strong> volledige CRUD, filtering, database en validatie.</li>
            <li><strong>Haalbaar:</strong> compact genoeg om binnen de hackathon af te ronden.</li>
            <li><strong>Uitbreidbaar:</strong> later mogelijk met accounts, reacties en notificaties.</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
