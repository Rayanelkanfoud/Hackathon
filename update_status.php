<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('requests.php');
}

$id = (int) ($_POST['id'] ?? 0);
$status = trim((string) ($_POST['status'] ?? ''));

if ($id > 0 && in_array($status, STATUSES, true)) {
    $statement = db()->prepare('UPDATE help_requests SET status = :status WHERE id = :id');
    $statement->execute([
        'id' => $id,
        'status' => $status,
    ]);
}

redirect('request.php?id=' . $id);

