<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$search = trim((string) ($_GET['search'] ?? ''));
$category = trim((string) ($_GET['category'] ?? ''));
$status = trim((string) ($_GET['status'] ?? ''));

$where = [];
$params = [];

if ($search !== '') {
    $where[] = '(title LIKE :search OR description LIKE :search OR requester_name LIKE :search OR location LIKE :search)';
    $params['search'] = '%' . $search . '%';
}

if ($category !== '' && in_array($category, CATEGORIES, true)) {
    $where[] = 'category = :category';
    $params['category'] = $category;
}

if ($status !== '' && in_array($status, STATUSES, true)) {
    $where[] = 'status = :status';
    $params['status'] = $status;
}

$sql = 'SELECT * FROM help_requests';
if ($where !== []) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY created_at DESC';

try {
    $statement = db()->prepare($sql);
    $statement->execute($params);
    $requests = $statement->fetchAll();
} catch (Throwable $exception) {
    database_error_page($exception);
}

$activePage = 'requests';
require __DIR__ . '/includes/header.php';
?>

<section class="page-title">
    <p class="eyebrow">SamenSterk</p>
    <h1>Hulpvragen</h1>
    <p>Zoek, filter en beheer alle hulpvragen uit de buurt.</p>
</section>

<form class="filters" method="get" action="requests.php" data-filter-form>
    <label>
        Zoeken
        <input type="search" name="search" value="<?= e($search) ?>" placeholder="Zoek op titel, naam of buurt">
    </label>
    <label>
        Categorie
        <select name="category">
            <option value="">Alle categorieen</option>
            <?php foreach (CATEGORIES as $item): ?>
                <option value="<?= e($item) ?>" <?= $category === $item ? 'selected' : '' ?>><?= e($item) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>
        Status
        <select name="status">
            <option value="">Alle statussen</option>
            <?php foreach (STATUSES as $item): ?>
                <option value="<?= e($item) ?>" <?= $status === $item ? 'selected' : '' ?>><?= e(status_label($item)) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button class="button primary" type="submit">Filter</button>
    <a class="button secondary" href="requests.php">Reset</a>
</form>

<section class="content-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow"><?= count($requests) ?> resultaat/resultaten</p>
            <h2>Beschikbare hulpvragen</h2>
        </div>
        <a class="button primary" href="create.php">Nieuwe hulpvraag</a>
    </div>

    <?php if ($requests === []): ?>
        <div class="empty-state">
            <h3>Geen hulpvragen gevonden</h3>
            <p>Pas je filters aan of plaats een nieuwe hulpvraag.</p>
        </div>
    <?php else: ?>
        <div class="request-list">
            <?php foreach ($requests as $request): ?>
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
                    <div class="card-actions">
                        <a class="button secondary" href="request.php?id=<?= (int) $request['id'] ?>">Details</a>
                        <a class="button secondary" href="edit.php?id=<?= (int) $request['id'] ?>">Wijzig</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

