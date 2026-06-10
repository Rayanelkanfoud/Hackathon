<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$id = (int) ($_GET['id'] ?? 0);
$request = $id > 0 ? find_request($id) : null;

if ($request === null) {
    http_response_code(404);
    $activePage = 'requests';
    require __DIR__ . '/includes/header.php';
    echo '<section class="empty-state"><h1>Hulpvraag niet gevonden</h1><a class="button primary" href="requests.php">Terug</a></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = [
        'id' => $id,
        'title' => trim((string) ($_POST['title'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')),
        'category' => trim((string) ($_POST['category'] ?? '')),
        'requester_name' => trim((string) ($_POST['requester_name'] ?? '')),
        'location' => trim((string) ($_POST['location'] ?? '')),
        'contact' => trim((string) ($_POST['contact'] ?? '')),
        'status' => trim((string) ($_POST['status'] ?? 'open')),
    ];
    $errors = validate_request($request);

    if ($errors === []) {
        $statement = db()->prepare(
            'UPDATE help_requests
             SET title = :title,
                 description = :description,
                 category = :category,
                 requester_name = :requester_name,
                 location = :location,
                 contact = :contact,
                 status = :status
             WHERE id = :id'
        );
        $statement->execute($request);
        redirect('request.php?id=' . $id);
    }
}

$activePage = 'requests';
require __DIR__ . '/includes/header.php';
?>

<section class="page-title">
    <p class="eyebrow">Update</p>
    <h1>Hulpvraag wijzigen</h1>
    <p>Pas de hulpvraag aan en sla de wijziging op.</p>
</section>

<form class="form-card" method="post" action="edit.php?id=<?= (int) $id ?>" data-request-form>
    <?php require __DIR__ . '/includes/request_form.php'; ?>
    <div class="form-actions">
        <button class="button primary" type="submit">Wijzigingen opslaan</button>
        <a class="button secondary" href="request.php?id=<?= (int) $id ?>">Annuleren</a>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>

