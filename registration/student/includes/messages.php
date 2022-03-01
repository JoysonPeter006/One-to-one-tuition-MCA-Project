<?php

 if (strlen($err_msg > 0)) : ?>


    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $err_msg ?>
    </div>


<?php endif; ?>

<?php if (strlen($succ_msg > 0)) : ?>


    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $succ_msg ?>
    </div>



<?php endif; ?>