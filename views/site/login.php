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
                <?php $hasError = $errors->has("password") ?>
                <label for="password">Пароль</label>
                <input name="password" class="form-control <?= $hasError ? 'is-invalid' : '' ?>" type="password"
                       id="password" placeholder="Пароль" value="<?= htmlspecialchars($formData->get('password')) ?>">
                <?php if ($hasError) { ?>
                    <div class="invalid-feedback">
                        <?= implode('<br/>', $errors->get("password")) ?>
                    </div>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Аутентификация</button>
        </form>
    </div>
</div>