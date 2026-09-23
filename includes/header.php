<?php

$pageTitle = $pageTitle ?? 'История проектов';

$isAdminPage = strpos(
    $_SERVER['SCRIPT_NAME'],
    '/admin/'
) !== false;

$rootPath = $isAdminPage ? '../' : '';

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= e($pageTitle) ?></title>

    <link
        rel="stylesheet"
        href="<?= $rootPath ?>assets/style.css"
    >

</head>

<body>

<header class="site-header">

    <div class="container header-inner">

        <a
            href="<?= $rootPath ?>index.php"
            class="logo"
        >
            История проектов
        </a>

        <nav class="main-nav">

            <a href="<?= $rootPath ?>index.php">
                Проекты
            </a>

            <a href="<?= $rootPath ?>admin/index.php">
                Администрирование
            </a>

        </nav>

    </div>

</header>

<main class="container">