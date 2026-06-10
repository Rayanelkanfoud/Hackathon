<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

$request = [
    'title' => '',
    'description' => '',
    'category' => '',
    'requester_name' => '',
        'location' => '',
        'contact' => '',
        'priority' => 'normaal',
        'needed_by' => '',
        'status' => 'open',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = [
        'title' => trim((string) ($_POST['title'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')),
        'category' => trim((string) ($_POST['category'] ?? '')),
        'requester_name' => trim((string) ($_POST['requester_name'] ?? '')),
        'location' => trim((string) ($_POST['location'] ?? '')),
        'contact' => trim((string) ($_POST['contact'] ?? '')),
        'priority' => trim((string) ($_POST['priority'] ?? 'normaal')),
        'needed_by' => trim((string) ($_POST['needed_by'] ?? '')),
        'status' => trim((string) ($_POST['status'] ?? 'open')),
    ];
    $request['needed_by'] = $request['needed_by'] === '' ? null : $request['needed_by'];
    $errors = validate_request($request);

    if ($errors === []) {
        $statement = db()->prepare(
            'INSERT INTO help_requests (title, description, category, requester_name, location, contact, priority, needed_by, status)
             VALUES (:title, :description, :category, :requester_name, :location, :contact, :priority, :needed_by, :status)'
        );
        $statement->execute($request);
        redirect('requests.php');
    }
}

$activePage = 'create';
require __DIR__ . '/includes/header.php';
?>

<section class="page-title">
    <p class="eyebrow">Create</p>
    <h1>Nieuwe hulpvraag</h1>
    <p>Vul de gegevens duidelijk in zodat buurtbewoners snel kunnen reageren.</p>
</section>

<form class="form-card" method="post" action="create.php" data-request-form>
    <?php require __DIR__ . '/includes/request_form.php'; ?>
    <div class="form-actions">
        <button class="button primary" type="submit">Opslaan</button>
        <a class="button secondary" href="requests.php">Annuleren</a>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
