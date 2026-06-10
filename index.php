<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

try {
    $counts = request_count_by_status();
    $latestStatement = db()->query('SELECT * FROM help_requests ORDER BY created_at DESC LIMIT 3');
    $latestRequests = $latestStatement->fetchAll();
} catch (Throwable $exception) {
    database_error_page($exception);
}

$activePage = 'home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div>
        <p class="eyebrow">Hackathon casus 1</p>
        <h1>SamenSterk helpt buren elkaar sneller vinden.</h1>
        <p>Een praktisch platform waar buurtbewoners hulpvragen plaatsen en vrijwilligers direct kunnen zien waar zij kunnen helpen.</p>
        <div class="hero-actions">
            <a class="button primary" href="create.php">Plaats hulpvraag</a>
            <a class="button secondary" href="requests.php">Bekijk hulpvragen</a>
        </div>
    </div>
    <aside class="hero-panel" aria-label="Projectdoelen">
        <h2>Techstack bewijs</h2>
        <ul>
            <li>CRUD met PHP en MySQL</li>
            <li>Interactieve filters met JavaScript</li>
            <li>Responsive HTML/CSS interface</li>
            <li>Veilige PDO prepared statements</li>
        </ul>
    </aside>
</section>

<section class="stats-grid" aria-label="Status overzicht">
    <article>
        <span><?= $counts['open'] ?></span>
        <p>Open hulpvragen</p>
    </article>
    <article>
        <span><?= $counts['in_behandeling'] ?></span>
        <p>In behandeling</p>
    </article>
    <article>
        <span><?= $counts['opgelost'] ?></span>
        <p>Opgelost</p>
    </article>
</section>

<section class="content-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Nieuwste aanvragen</p>
            <h2>Recente hulpvragen</h2>
        </div>
        <a href="requests.php">Alle hulpvragen</a>
    </div>

    <div class="request-list">
        <?php foreach ($latestRequests as $request): ?>
            <article class="request-card">
                <div class="card-topline">
                    <span class="category"><?= e($request['category']) ?></span>
                    <span class="status <?= e(status_class($request['status'])) ?>"><?= e(status_label($request['status'])) ?></span>
                </div>
                <h3><?= e($request['title']) ?></h3>
                <p><?= e($request['description']) ?></p>
                <div class="meta">
                    <span><?= e($request['requester_name']) ?></span>
                    <span><?= e($request['location']) ?></span>
                </div>
                <a class="text-link" href="request.php?id=<?= (int) $request['id'] ?>">Details bekijken</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

