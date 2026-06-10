<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('requests.php');
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $statement = db()->prepare('DELETE FROM help_requests WHERE id = :id');
    $statement->execute(['id' => $id]);
}

redirect('requests.php');

