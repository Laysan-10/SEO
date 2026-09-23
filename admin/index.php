<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Администрирование проектов';

$stmt = $pdo->query(
    "SELECT
        projects.id,
        projects.title,
        projects.project_date,
        projects.status,
        categories.name AS category_name
     FROM projects
     INNER JOIN categories
        ON projects.category_id = categories.id
     ORDER BY projects.created_at DESC"
);

$projects = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="admin-header">

    <div>

        <h1>Администрирование</h1>

        <p>
            Управление проектами
        </p>

    </div>

    <a href="create.php" class="btn">
        + Добавить проект
    </a>

</section>

<?php if (isset($_GET['success'])): ?>

    <div class="success-message">
        Операция выполнена успешно.
    </div>

<?php endif; ?>

<div class="admin-table-wrapper">

    <?php if (empty($projects)): ?>

        <div class="empty-message">
            Проектов пока нет.
        </div>

    <?php else: ?>

        <table class="admin-table">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Название</th>

                    <th>Категория</th>

                    <th>Дата</th>

                    <th>Статус</th>

                    <th>Действия</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($projects as $project): ?>

                    <tr>

                        <td>
                            <?= (int)$project['id'] ?>
                        </td>

                        <td>
                            <?= e($project['title']) ?>
                        </td>

                        <td>
                            <?= e($project['category_name']) ?>
                        </td>

                        <td>
                            <?= formatDate($project['project_date']) ?>
                        </td>

                        <td>

                            <?php if ($project['status'] === 'published'): ?>

                                <span class="status status-published">
                                    Published
                                </span>

                            <?php else: ?>

                                <span class="status status-draft">
                                    Draft
                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="actions">

                            <a
                                href="edit.php?id=<?= (int)$project['id'] ?>"
                                class="btn btn-small"
                            >
                                Изменить
                            </a>

                            <a
                                href="delete.php?id=<?= (int)$project['id'] ?>"
                                class="btn btn-small btn-danger"
                                onclick="return confirm('Вы действительно хотите удалить проект?');"
                            >
                                Удалить
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>