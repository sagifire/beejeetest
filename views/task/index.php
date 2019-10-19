<?php
/** @var array $list */
/** @var \app\ViewController $this */
/** @var string $sortColumn */
/** @var bool $descending */

use app\helpers\SortLink;
use app\Application as App;
$url = new \app\helpers\UrlMixer(App::getInstance()->request->getRequestUri());

?>
<div class="row">
    <div class="col-12 py-4">
        <a href="/task/create" class="btn btn-primary" role="button">Создать новую задачу</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
    <?php if (!$list->count()) { ?>
        <span>Задач не найдено</span>
    <?php } else { ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="white-space: nowrap;"><?= SortLink::make('username', 'Имя пользователя') ?></th>
                    <th scope="col"><?= SortLink::make('email', 'Email') ?></th>
                    <th scope="col">Текст задачи</th>
                    <th scope="col"><?= SortLink::make('status', 'Статус') ?></th>
                    <?php if (App::getInstance()->user->isAdmin()) { ?>
                    <th></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach($list as $item) { ?>
                <?php /** @var \app\models\Task $item */ ?>
                <tr>
                    <td><?= htmlspecialchars($item->username) ?></td>
                    <td><?= htmlspecialchars($item->email) ?></td>
                    <td><?= str_replace("\n", "<br/>", htmlspecialchars($item->description)) ?></td>
                    <td>
                        <?php if($item->isEdited()) { ?>
                            <i class="fa fa-fw fa-asterisk" data-toggle="tooltip" data-placement="right" title="Отредактировано администратором"></i>
                        <?php } ?>
                        <?php if($item->isCompleted()) { ?>
                            <i class="fa fa-fw fa-check" data-toggle="tooltip" data-placement="left" title="Выполнено"></i>
                        <?php } ?>
                    </td>
                    <?php if (App::getInstance()->user->isAdmin()) { ?>
                    <td><a href="/task/edit/<?= $item->id ?>"><i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="right" title="Изменить"></i></a></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php if ($list->total() > $this::DEFAULT_PER_PAGE) { ?>
            <nav aria-label="Task pages navigation" class="float-right">
                <ul class="pagination">
                    <?php for ($p = 1; $p <= $list->lastPage(); $p++) { ?>
                        <?php if ($list->currentPage() == $p) { ?>
                        <li class="page-item active"><a class="page-link"><?= $p ?></a></li>
                        <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="<?= $url->mix(['page' => $p]) ?>"><?= $p ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </nav>
        <?php } ?>
    <?php } ?>
    </div>
</div>