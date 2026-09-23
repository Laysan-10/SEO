<?php

function e($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


function formatDate($date)
{
    if (empty($date)) {
        return '';
    }

    return date('d.m.Y', strtotime($date));
}


/*
 * Получение одного проекта
 */
function getProject(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare(
        "SELECT
            projects.id,
            projects.title,
            projects.short_description,
            projects.description,
            projects.project_date,
            projects.category_id,
            projects.image,
            projects.status,
            projects.client,
            projects.technologies,
            projects.project_url,
            categories.name AS category_name
         FROM projects
         INNER JOIN categories
            ON projects.category_id = categories.id
         WHERE projects.id = :id
         LIMIT 1"
    );

    $stmt->execute([
        'id' => $id
    ]);

    return $stmt->fetch();
}


/*
 * Получение всех категорий
 */
function getCategories(PDO $pdo)
{
    $stmt = $pdo->query(
        "SELECT
            id,
            name
         FROM categories
         ORDER BY name ASC"
    );

    return $stmt->fetchAll();
}


/*
 * Проверка существования категории
 */
function categoryExists(PDO $pdo, int $categoryId)
{
    $stmt = $pdo->prepare(
        "SELECT id
         FROM categories
         WHERE id = ?
         LIMIT 1"
    );

    $stmt->execute([
        $categoryId
    ]);

    return (bool)$stmt->fetch();
}


/*
 * Проверка статуса проекта
 */
function isValidStatus(string $status)
{
    return in_array(
        $status,
        ['draft', 'published'],
        true
    );
}