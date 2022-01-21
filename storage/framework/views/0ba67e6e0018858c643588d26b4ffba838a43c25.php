<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(__('auth.your registration was successful')); ?>

    </div>
<?php endif; ?>
<?php if(session('failed')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.user or password was wrong'); ?>
    </div>
<?php endif; ?>

<?php if(session('emailVerified')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.email has verified'); ?>
    </div>
<?php endif; ?>

<?php if(session('resetLinkSent')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.reset link sent'); ?>
    </div>
<?php endif; ?>

<?php if(session('resetLinkFailed')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.reset link failed'); ?>
    </div>
<?php endif; ?>
<?php if(session('passwordChanged')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.passwordChanged'); ?>
    </div>
<?php endif; ?>
<?php if(session('cantChangePassword')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.cantChangePassword'); ?>
    </div>
<?php endif; ?>
<?php if(session('magicLinkSent')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.magicLinkSent'); ?>
    </div>
<?php endif; ?>
<?php if(session('invalidToken')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.invalidToken'); ?>
    </div>
<?php endif; ?>

<?php if(session('cantSendCode')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.cantSendCode'); ?>
    </div>
<?php endif; ?>
<?php if(session('twoFactorActivated')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.twoFactorActivated'); ?>
    </div>
<?php endif; ?>
<?php if(session('invalidCode')): ?>
    <div class="alert alert-danger">
        <?php echo app('translator')->get('auth.invalidCode'); ?>
    </div>
<?php endif; ?>
<?php if(session('twoFactorDeactivated')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.twoFactorDeactivated'); ?>
    </div>
<?php endif; ?>
<?php if(session('codeResent')): ?>
    <div class="alert alert-success">
        <?php echo app('translator')->get('auth.codeResent'); ?>
    </div>
<?php endif; ?>
<?php if(session('addToBasket')): ?>
    <div class="alert alert-success">
        <?php echo e(session('addToBasket')); ?>

    </div>
<?php endif; ?>
<?php if(session('successCheckout')): ?>
    <div class="alert alert-success">
        <?php echo e(session('successCheckout')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-success">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>
<?php if(session('quantityExceeded')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('quantityExceeded')); ?>

    </div>
<?php endif; ?>



<?php /**PATH /home/mohammad/web/www/auth/resources/views/partials/alerts.blade.php ENDPATH**/ ?>