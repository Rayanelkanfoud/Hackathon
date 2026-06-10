<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

const CATEGORIES = ['Boodschappen', 'Computerhulp', 'Tuin', 'Klusje', 'Gezelschap', 'Overig'];
const STATUSES = ['open', 'in_behandeling', 'opgelost'];
const PRIORITIES = ['laag', 'normaal', 'hoog'];

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function status_label(string $status): string
{
    return match ($status) {
        'open' => 'Open',
        'in_behandeling' => 'In behandeling',
        'opgelost' => 'Opgelost',
        default => 'Onbekend',
    };
}

function status_class(string $status): string
{
    return match ($status) {
        'open' => 'status-open',
        'in_behandeling' => 'status-progress',
        'opgelost' => 'status-done',
        default => '',
    };
}

function priority_label(string $priority): string
{
    return match ($priority) {
        'laag' => 'Lage prioriteit',
        'normaal' => 'Normaal',
        'hoog' => 'Hoge prioriteit',
        default => 'Normaal',
    };
}

function priority_class(string $priority): string
{
    return match ($priority) {
        'laag' => 'priority-low',
        'normaal' => 'priority-normal',
        'hoog' => 'priority-high',
        default => 'priority-normal',
    };
}

function validate_request(array $data): array
{
    $errors = [];

    foreach (['title', 'description', 'category', 'requester_name', 'location', 'contact'] as $field) {
        if (trim((string) ($data[$field] ?? '')) === '') {
            $errors[$field] = 'Dit veld is verplicht.';
        }
    }

    if (($data['category'] ?? '') !== '' && !in_array($data['category'], CATEGORIES, true)) {
        $errors['category'] = 'Kies een geldige categorie.';
    }

    if (($data['status'] ?? 'open') !== '' && !in_array($data['status'], STATUSES, true)) {
        $errors['status'] = 'Kies een geldige status.';
    }

    if (($data['priority'] ?? 'normaal') !== '' && !in_array($data['priority'], PRIORITIES, true)) {
        $errors['priority'] = 'Kies een geldige prioriteit.';
    }

    if (($data['needed_by'] ?? '') !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $data['needed_by'])) {
        $errors['needed_by'] = 'Gebruik een geldige datum.';
    }

    if (strlen(trim((string) ($data['title'] ?? ''))) > 120) {
        $errors['title'] = 'De titel mag maximaal 120 tekens zijn.';
    }

    return $errors;
}

function find_request(int $id): ?array
{
    $statement = db()->prepare('SELECT * FROM help_requests WHERE id = :id');
    $statement->execute(['id' => $id]);
    $request = $statement->fetch();

    return $request ?: null;
}

function request_count_by_status(): array
{
    $counts = array_fill_keys(STATUSES, 0);
    $statement = db()->query('SELECT status, COUNT(*) AS total FROM help_requests GROUP BY status');

    foreach ($statement->fetchAll() as $row) {
        $counts[$row['status']] = (int) $row['total'];
    }

    return $counts;
}

function format_date(?string $date): string
{
    if ($date === null || $date === '') {
        return 'Geen datum';
    }

    return date('d-m-Y', strtotime($date));
}

function database_error_page(Throwable $exception): never
{
    http_response_code(500);
    $message = e($exception->getMessage());
    echo <<<HTML
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database niet bereikbaar</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="setup-error">
        <h1>Database niet bereikbaar</h1>
        <p>Controleer of WAMP draait en of je <code>database/schema.sql</code> hebt geimporteerd in phpMyAdmin.</p>
        <p class="muted">Technische melding: {$message}</p>
    </main>
</body>
</html>
HTML;
    exit;
}
