<?php if( Yii::app()->user->hasFlash('rightsSuccess')===true ):?>

    <div class="rightsFlash success">

        <?php echo Yii::app()->user->getFlash('rightsSuccess'); ?>

    </div>

<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('rightsError')===true ):?>

    <div class="rightsFlash error">

        <?php echo Yii::app()->user->getFlash('rightsError'); ?>

    </div>

<?php endif; ?>