<?php if(count($errors) > 0): ?>
    <div class="errors">
        <?php foreach($errors as $error): ?>
            <?= $error; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>