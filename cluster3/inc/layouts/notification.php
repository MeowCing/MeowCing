<?php
if (($errorMSG != '')) {
?>
    <div class="mb-3">
        <div class="alert alert-danger" role="alert" style="font-size: 14px;">
            <?php echo $errorMSG; ?>
        </div>
    </div>
<?php
}

if (($successMSG != '')) {
?>
    <div class="mb-3">
        <div class="alert alert-success" role="alert" style="font-size: 14px;">
            <?php echo $successMSG; ?>
        </div>
    </div>
<?php
}
?>