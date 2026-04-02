<?php if (!empty($errors)): ?>
    <div class="message border rounded bg-red-100 border-red-500 text-red-500 p-3 my-3">
        <p>There was a problem with your submission:</p>
        <ul class="list-disc ml-4">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>