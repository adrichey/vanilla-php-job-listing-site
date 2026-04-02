<?php if (!empty($errors)): ?>
    <div class="message border rounded bg-red-100 border-red-500 text-red-500 p-3 my-3">
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>