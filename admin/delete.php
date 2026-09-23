<?php

require_once __DIR__ . '/../includes/db.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id || $id <= 0) {

    die('Некорректный ID проекта.');
}

$stmt = $pdo->prepare(
    "DELETE FROM projects
     WHERE id = ?"
);

$stmt->execute([$id]);

header('Location: index.php?success=1');

exit;