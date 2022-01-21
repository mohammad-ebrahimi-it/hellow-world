<?php $__env->startSection('title' , __('public.main page')); ?>


<?php $__env->startSection('content'); ?>

<div class="flex-center course-title position-ref full-height">
            <div class="content">
                <?php echo $__env->make('partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="title m-b-md">
                    <?php echo app('translator')->get('public.register & login system'); ?>
                </div>
                <div class="library-title">
                    <?php echo app('translator')->get('public.practical laravel'); ?>
                </div>
            </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mohammad/web/www/auth/resources/views/welcome.blade.php ENDPATH**/ ?>