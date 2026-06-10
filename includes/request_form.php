<?php
$request = $request ?? [
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
$errors = $errors ?? [];
?>
<div class="form-grid">
    <label>
        Titel
        <input type="text" name="title" value="<?= e($request['title']) ?>" maxlength="120" required>
        <?php if (isset($errors['title'])): ?><span class="error"><?= e($errors['title']) ?></span><?php endif; ?>
    </label>

    <label>
        Categorie
        <select name="category" required>
            <option value="">Kies categorie</option>
            <?php foreach (CATEGORIES as $category): ?>
                <option value="<?= e($category) ?>" <?= $request['category'] === $category ? 'selected' : '' ?>>
                    <?= e($category) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['category'])): ?><span class="error"><?= e($errors['category']) ?></span><?php endif; ?>
    </label>

    <label class="span-2">
        Omschrijving
        <textarea name="description" rows="6" required><?= e($request['description']) ?></textarea>
        <?php if (isset($errors['description'])): ?><span class="error"><?= e($errors['description']) ?></span><?php endif; ?>
    </label>

    <label>
        Naam aanvrager
        <input type="text" name="requester_name" value="<?= e($request['requester_name']) ?>" required>
        <?php if (isset($errors['requester_name'])): ?><span class="error"><?= e($errors['requester_name']) ?></span><?php endif; ?>
    </label>

    <label>
        Buurt of locatie
        <input type="text" name="location" value="<?= e($request['location']) ?>" required>
        <?php if (isset($errors['location'])): ?><span class="error"><?= e($errors['location']) ?></span><?php endif; ?>
    </label>

    <label>
        Contact
        <input type="text" name="contact" value="<?= e($request['contact']) ?>" required>
        <?php if (isset($errors['contact'])): ?><span class="error"><?= e($errors['contact']) ?></span><?php endif; ?>
    </label>

    <label>
        Prioriteit
        <select name="priority">
            <?php foreach (PRIORITIES as $priority): ?>
                <option value="<?= e($priority) ?>" <?= $request['priority'] === $priority ? 'selected' : '' ?>>
                    <?= e(priority_label($priority)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['priority'])): ?><span class="error"><?= e($errors['priority']) ?></span><?php endif; ?>
    </label>

    <label>
        Gewenst voor
        <input type="date" name="needed_by" value="<?= e($request['needed_by']) ?>">
        <?php if (isset($errors['needed_by'])): ?><span class="error"><?= e($errors['needed_by']) ?></span><?php endif; ?>
    </label>

    <label>
        Status
        <select name="status">
            <?php foreach (STATUSES as $status): ?>
                <option value="<?= e($status) ?>" <?= $request['status'] === $status ? 'selected' : '' ?>>
                    <?= e(status_label($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['status'])): ?><span class="error"><?= e($errors['status']) ?></span><?php endif; ?>
    </label>
</div>
