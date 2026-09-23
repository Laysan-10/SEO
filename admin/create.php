<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Добавление проекта';

$categories = getCategories($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');

    $shortDescription = trim(
        $_POST['short_description'] ?? ''
    );

    $description = trim(
        $_POST['description'] ?? ''
    );

    $projectDate = $_POST['project_date'] ?? '';

    $categoryId = (int)(
        $_POST['category_id'] ?? 0
    );

    $image = trim(
        $_POST['image'] ?? ''
    );

    $status = $_POST['status'] ?? 'draft';

    $client = trim(
        $_POST['client'] ?? ''
    );

    $technologies = trim(
        $_POST['technologies'] ?? ''
    );

    $projectUrl = trim(
        $_POST['project_url'] ?? ''
    );

    if (
        $title === '' ||
        $shortDescription === '' ||
        $description === '' ||
        $projectDate === ''
    ) {

        $error = 'Заполните все обязательные поля.';

    } elseif (!categoryExists($pdo, $categoryId)) {

        $error = 'Выбрана некорректная категория.';

    } elseif (!isValidStatus($status)) {

        $error = 'Выбран некорректный статус.';

    } else {

        $stmt = $pdo->prepare(
            "INSERT INTO projects (
                title,
                short_description,
                description,
                project_date,
                category_id,
                image,
                status,
                client,
                technologies,
                project_url
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $title,
            $shortDescription,
            $description,
            $projectDate,
            $categoryId,
            $image,
            $status,
            $client !== '' ? $client : null,
            $technologies !== '' ? $technologies : null,
            $projectUrl !== '' ? $projectUrl : null
        ]);

        header('Location: index.php?success=1');

        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="form-section">

    <h1>Добавление проекта</h1>

    <?php if ($error !== ''): ?>

        <div class="error-message">
            <?= e($error) ?>
        </div>

    <?php endif; ?>

    <form
        method="POST"
        class="project-form"
    >

        <div class="form-group">

            <label for="title">
                Название *
            </label>

            <input
                type="text"
                id="title"
                name="title"
                maxlength="255"
                required
                value="<?= e($_POST['title'] ?? '') ?>"
            >

        </div>

        <div class="form-group">

            <label for="short_description">
                Краткое описание *
            </label>

            <textarea
                id="short_description"
                name="short_description"
                maxlength="500"
                rows="3"
                required
            ><?= e($_POST['short_description'] ?? '') ?></textarea>

        </div>

        <div class="form-group">

            <label for="description">
                Полное описание *
            </label>

            <textarea
                id="description"
                name="description"
                rows="8"
                required
            ><?= e($_POST['description'] ?? '') ?></textarea>

        </div>

        <div class="form-row">

            <div class="form-group">

                <label for="project_date">
                    Дата проекта *
                </label>

                <input
                    type="date"
                    id="project_date"
                    name="project_date"
                    required
                    value="<?= e($_POST['project_date'] ?? '') ?>"
                >

            </div>

            <div class="form-group">

                <label for="category_id">
                    Категория *
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                >

                    <option value="">
                        Выберите категорию
                    </option>

                    <?php foreach ($categories as $category): ?>

                        <option
                            value="<?= (int)$category['id'] ?>"
                            <?= (
                                ($_POST['category_id'] ?? '') ==
                                $category['id']
                            ) ? 'selected' : '' ?>
                        >
                            <?= e($category['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </div>

        <div class="form-group">

            <label for="image">
                Изображение
            </label>

            <input
                type="text"
                id="image"
                name="image"
                placeholder="images/project.jpg"
                value="<?= e($_POST['image'] ?? '') ?>"
            >

        </div>

        <div class="form-group">

            <label for="status">
                Статус *
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option value="draft">
                    Draft
                </option>

                <option
                    value="published"
                    <?= (
                        ($_POST['status'] ?? '') ===
                        'published'
                    ) ? 'selected' : '' ?>
                >
                    Published
                </option>

            </select>

        </div>

        <div class="form-group">

            <label for="client">
                Клиент
            </label>

            <input
                type="text"
                id="client"
                name="client"
                maxlength="255"
                value="<?= e($_POST['client'] ?? '') ?>"
            >

        </div>

        <div class="form-group">

            <label for="technologies">
                Технологии
            </label>

            <input
                type="text"
                id="technologies"
                name="technologies"
                maxlength="500"
                placeholder="PHP, MySQL, HTML, CSS"
                value="<?= e($_POST['technologies'] ?? '') ?>"
            >

        </div>

        <div class="form-group">

            <label for="project_url">
                Ссылка на проект
            </label>

            <input
                type="url"
                id="project_url"
                name="project_url"
                maxlength="500"
                value="<?= e($_POST['project_url'] ?? '') ?>"
            >

        </div>

        <div class="form-buttons">

            <button
                type="submit"
                class="btn"
            >
                Сохранить
            </button>

            <a
                href="index.php"
                class="btn btn-secondary"
            >
                Отмена
            </a>

        </div>

    </form>

</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>