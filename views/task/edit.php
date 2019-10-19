<?php
/** @var \Symfony\Component\HttpFoundation\ParameterBag $formData */
/** @var \Illuminate\Support\MessageBag $errors */
?>
<div class="row">
    <div class="col-6 py-4">
        <form method="post">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input name="username" class="form-control" id="username" disabled="disabled"
                       value="<?= htmlspecialchars($formData->get('username')) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" class="form-control" id="email" disabled="disabled"
                       value="<?= htmlspecialchars($formData->get('email')) ?>">
            </div>
            <div class="form-group">
                <?php $hasError = $errors->has("description") ?>
                <label for="description">Текст задачи</label>
                <textarea name="description" class="form-control  <?= $hasError ? 'is-invalid' : '' ?>" id="description"
                          rows="3"><?= htmlspecialchars($formData->get('description')) ?></textarea>
                <?php if ($hasError) { ?>
                    <div class="invalid-feedback">
                        <?= implode('<br/>', $errors->get("description")) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group form-check">
                <input type="hidden" name="completed" value="0">
                <input type="checkbox" class="form-check-input" id="completed" name="completed" value="1"
                    <?= $formData->get('completed') ? 'checked' : '' ?> >
                <label class="form-check-label" for="completed">Выполнено</label>
            </div>
            <button type="submit" class="btn btn-primary">Изменить</button>
        </form>
    </div>
</div>