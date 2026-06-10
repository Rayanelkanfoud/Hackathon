<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$id = (int) ($_GET['id'] ?? 0);
$request = $id > 0 ? find_request($id) : null;

if ($request === null) {
    http_response_code(404);
}

$activePage = 'requests';
require __DIR__ . '/includes/header.php';
?>

<?php if ($request === null): ?>
    <section class="empty-state">
        <h1>Hulpvraag niet gevonden</h1>
        <p>Deze hulpvraag bestaat niet meer of de link klopt niet.</p>
        <a class="button primary" href="requests.php">Terug naar overzicht</a>
    </section>
<?php else: ?>
    <section class="detail-layout">
        <article class="detail-card">
            <div class="card-topline">
                <span class="category"><?= e($request['category']) ?></span>
                <span class="priority <?= e(priority_class($request['priority'])) ?>"><?= e(priority_label($request['priority'])) ?></span>
                <span class="status <?= e(status_class($request['status'])) ?>"><?= e(status_label($request['status'])) ?></span>
            </div>
            <h1><?= e($request['title']) ?></h1>
            <p><?= nl2br(e($request['description'])) ?></p>

            <dl class="detail-list">
                <div>
                    <dt>Aanvrager</dt>
                    <dd><?= e($request['requester_name']) ?></dd>
                </div>
                <div>
                    <dt>Locatie</dt>
                    <dd><?= e($request['location']) ?></dd>
                </div>
                <div>
                    <dt>Contact</dt>
                    <dd><?= e($request['contact']) ?></dd>
                </div>
                <div>
                    <dt>Gewenst voor</dt>
                    <dd><?= e(format_date($request['needed_by'])) ?></dd>
                </div>
                <div>
                    <dt>Prioriteit</dt>
                    <dd><?= e(priority_label($request['priority'])) ?></dd>
                </div>
            </dl>

            <div class="form-actions">
                <a class="button primary" href="edit.php?id=<?= (int) $request['id'] ?>">Wijzig hulpvraag</a>
                <form method="post" action="delete.php" data-confirm="Weet je zeker dat je deze hulpvraag wilt verwijderen?">
                    <input type="hidden" name="id" value="<?= (int) $request['id'] ?>">
                    <button class="button danger" type="submit">Verwijderen</button>
                </form>
            </div>
        </article>

        <aside class="status-panel">
            <h2>Status aanpassen</h2>
            <p>Gebruik dit als iemand de hulpvraag oppakt of afrondt.</p>
            <form method="post" action="update_status.php">
                <input type="hidden" name="id" value="<?= (int) $request['id'] ?>">
                <label>
                    Nieuwe status
                    <select name="status">
                        <?php foreach (STATUSES as $status): ?>
                            <option value="<?= e($status) ?>" <?= $request['status'] === $status ? 'selected' : '' ?>>
                                <?= e(status_label($status)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button class="button primary" type="submit">Status opslaan</button>
            </form>
        </aside>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
