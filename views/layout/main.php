<?php
/** @var string $content */
/** @var \app\ViewController $this */

use app\Application as App;

$headTitle = [ App::getInstance()->name ];
if (!empty($this->pageTitle)) {
    $headTitle[] = $this->pageTitle;
}

$flashBag = App::getInstance()->session->getFlashBag();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- favicon -->
    <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAABoL/AAeC/wAIg/8ACYP/ABKI/wAAf/8AAX//AAGA/wACgP8AFor/AASB/wANhv8AGIv/AAAAAAAAAAAAAAZmAAZmAAAAZmZmZmZgAABmZmZmZmAAAGZmZmZmYAAAZmZmZmYAAAAGZmZmZgAAAABmZmZgZmAG0AZmZgBmZmZhAGZgAGZlZmsAAAAANmiGbAZgBmAGa3ZgZmYGZgBmZgAmZAZmYAAAABZmCGZgAAAAZmYGZmAAAAAJoABmAADjjwAAwAcAAMAHAADABwAAwA8AAOAPAADwEQAAmDAAAAxwAAAP8AAACZgAABCMAAAwhwAA8IcAAPCHAAD5zwAA" rel="icon" type="image/x-icon" />

    <!-- icons -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap 4 css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title><?= implode(' | ', $headTitle) ?></title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container flex-column flex-md-row">
            <a class="navbar-brand mr-0" href="/"><?= App::getInstance()->name ?></a>
            <span class="navbar-text"><?= $this->pageTitle ?></span>
            <ul class="navbar-nav mb-3 mb-md-0 ml-md-3">
                <li class="nav-item">
                    <?php if (App::getInstance()->user->isGuest()) { ?>
                    <a class="nav-link" href="/login">Вход</a>
                    <?php } else { ?>
                    <a class="nav-link" href="/logout">Выход (Admin)</span></a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if($flashBag->has('success')) { ?>
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    <?= current($flashBag->get('success')) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
                <?php if($flashBag->has('error')) { ?>
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <?= current($flashBag->get('error')) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
            </div>
        </div>

        <?= $content ?>
    </div>

    <!-- Bootstrap 4 js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>