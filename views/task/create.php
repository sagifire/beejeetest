<?php
/** @var \Symfony\Component\HttpFoundation\ParameterBag $formData */
/** @var \Illuminate\Support\MessageBag $errors */
?>
<div class="row">
    <div class="col-6 py-4">
        <form method="post">
            <div class="form-group">
                <?php $hasError = $errors->has("username") ?>
                <label for="username">Имя пользователя</label>
                <input name="username" class="form-control <?= $hasError ? 'is-invalid' : '' ?>"
                       id="username" placeholder="Имя пользователя" value="<?= htmlspecialchars($formData->get('username')) ?>">
                <?php if ($hasError) { ?>
                <div class="invalid-feedback">
                    <?= implode('<br/>', $errors->get("username")) ?>
                </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <?php $hasError = $errors->has("email") ?>
                <label for="email">Email</label>
                <input name="email" class="form-control <?= $hasError ? 'is-invalid' : '' ?>"
                       id="email" placeholder="Email" value="<?= htmlspecialchars($formData->get('email')) ?>">
                <?php if ($hasError) { ?>
                <div class="invalid-feedback">
                    <?= implode('<br/>', $errors->get("email")) ?>
                </div>
                <?php } ?>
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
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</div>