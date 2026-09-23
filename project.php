<?php

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id || $id <= 0) {

    http_response_code(404);

    die('Проект не найден.');
}

$project = getProject($pdo, $id);

if (
    !$project ||
    $project['status'] !== 'published'
) {

    http_response_code(404);

    die('Проект не найден.');
}

$pageTitle = $project['title'];

require_once __DIR__ . '/includes/header.php';
?>

<article class="project-details">

    <a href="index.php" class="back-link">
        ← Все проекты
    </a>

    <?php if (!empty($project['image'])): ?>

        <div class="project-details-image">

            <img
                src="<?= e($project['image']) ?>"
                alt="<?= e($project['title']) ?>"
            >

        </div>

    <?php endif; ?>

    <div class="project-details-content">

        <div class="project-meta">

            <span class="category">
                <?= e($project['category_name']) ?>
            </span>

            <span class="date">
                <?= formatDate($project['project_date']) ?>
            </span>

        </div>

        <h1>
            <?= e($project['title']) ?>
        </h1>

        <p class="project-short-description">
            <?= e($project['short_description']) ?>
        </p>

        <div class="project-description">

            <?= nl2br(e($project['description'])) ?>

        </div>

        <?php if (!empty($project['client'])): ?>

            <div class="project-info">

                <strong>Клиент:</strong>

                <?= e($project['client']) ?>

            </div>

        <?php endif; ?>

        <?php if (!empty($project['technologies'])): ?>

            <div class="project-info">

                <strong>Технологии:</strong>

                <?= e($project['technologies']) ?>

            </div>

        <?php endif; ?>

        <?php if (!empty($project['project_url'])): ?>

            <div class="project-info">

                <a
                    href="<?= e($project['project_url']) ?>"
                    class="btn"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Открыть проект
                </a>

            </div>

        <?php endif; ?>

    </div>

</article>

<?php require_once __DIR__ . '/includes/footer.php'; ?>