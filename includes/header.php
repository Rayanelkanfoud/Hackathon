<?php
$activePage = $activePage ?? '';
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SamenSterk - Buurt-Helpdesk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <a class="brand" href="index.php" aria-label="SamenSterk startpagina">
        <span class="brand-mark">SS</span>
        <span>
            <strong>SamenSterk</strong>
            <small>De Buurt-Helpdesk</small>
        </span>
    </a>
    <nav class="main-nav" aria-label="Hoofdnavigatie">
        <a class="<?= $activePage === 'home' ? 'active' : '' ?>" href="index.php">Dashboard</a>
        <a class="<?= $activePage === 'requests' ? 'active' : '' ?>" href="requests.php">Hulpvragen</a>
        <a class="<?= $activePage === 'create' ? 'active' : '' ?>" href="create.php">Nieuwe hulpvraag</a>
    </nav>
</header>
<main class="page-shell">

