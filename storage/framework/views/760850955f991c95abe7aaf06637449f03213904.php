<html dir="rtl" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstraprtl-v4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <?php echo $__env->yieldContent('links'); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>
<!-- Nav Menu -->
<?php echo $__env->make('partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(session('mustVerifyEmail')): ?>
    <div class="alert alert-danger text-center">

        <?php echo app('translator')->get('auth.you must verify your email', ['link' => route('auth.email.send.verification')]); ?>
    </div>
<?php endif; ?>
<?php if(session('verificationEmailSend')): ?>
    <div class="alert alert-success text-center">
        <?php echo app('translator')->get('auth.verification email sent'); ?>
    </div>
<?php endif; ?>
<div class="container">
    <?php echo $__env->yieldContent('content'); ?>
</div>
</body>

</html>
<?php /**PATH /home/mohammad/web/www/auth/resources/views/layouts/app.blade.php ENDPATH**/ ?>