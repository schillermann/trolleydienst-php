<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Update') ?></h2>
    <a href="./" class="button"><i class="fa fa-chevron-left"></i> <?= __('Back') ?></a>
</header>
<div class="container-center">
    
    <?php if($placeholder['is_up_to_date']) : ?>
        <div class="info-box">
            <p>
                <strong style="color:red"><?= __('WARNING') ?>:</strong> <?= __('For security reasons, please delete the update.php file from the server.') ?>
            </p>
        </div>
        <p><?= __('The database is up to date.') ?></p>
        <p>
        <?= __('As soon as a new version of Trolleydienst PHP from <a href="https://github.com/schillermann/trolleydienst-php/releases">github.com</a> is released, you can download it and upload it to your server.') ?>
        </p>
        <p>
        <?= __('When uploading, be sure to overwrite the existing files.') ?>
        <?= __('Alternatively, delete the old version before uploading the new version.') ?>
        <?= __('The files config.php and database.sqlite <strong style="color:red">MUST NOT BE</strong> deleted.') ?>
       </p>
       <p>
       <?= __('Now you need to start the update to update the database.') ?>
        </p>
    <?php else: ?>
        <div class="info-box">
            <p><?= __('The database needs to be updated.') ?></p>
        </div>
        <p>
            <strong style="color:red"><?= __('Please start the update now.') ?></strong>
        </p>
        <p>
            <form method="post">
               <div class="from-button">
                   <button name="update" class="active">
                       <i class="fa fa-floppy-o"></i> <?= __('Start update') ?>
                   </button>
               </div>
           </form>
       </p>
    <?php endif ?>
</div>