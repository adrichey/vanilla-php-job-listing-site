<?php
$fmSuccess = getFlashMessage('success');
if(!empty($fmSuccess)):
?>
    <div class="message bg-green-100 p-3 my-3">
        <?= $fmSuccess ?>
    </div>
<?php endif; ?>

<?php
$fmError = getFlashMessage('error');
if(!empty($fmError)):
?>
    <div class="message bg-red-100 p-3 my-3">
        <?= $fmError ?>
    </div>
<?php endif; ?>
