<?php $basket = app('App\Support\Basket\Basket'); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <a class="navbar-brand" href="#">
        <img src="<?php echo e(asset('img/logo.png')); ?>" width="30" height="30" class="d-inline-block align-top" alt="">
        آکادمی
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>



    <div class="auth-btn collapse justify-content-end navbar-collapse">
        <a href="<?php echo e(route('basket.index')); ?>" class="btn btn-info mr-2">
            <?php echo app('translator')->get('payment.basket'); ?>
            <span class="badge badge-light"> <?php echo e($basket->itemCount()); ?></span>
        </a>
        <?php if(auth()->guard()->check()): ?>
        <?php echo e(Auth::user()->name); ?>

        <?php endif; ?>
        <?php if(auth()->guard()->guest()): ?>
            <a class="btn btn-info  mr-2" href="<?php echo e(route('auth.login')); ?>"><?php echo app('translator')->get('public.login'); ?></a>
            <a class="btn btn-info mr-2" href="<?php echo e(route('auth.register.form')); ?>"><?php echo app('translator')->get('public.register'); ?></a>
        <?php endif; ?>
        <?php if(auth()->guard()->check()): ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">

                    </a>
                    <div class="dropdown-menu logout-btn" aria-labelledby="navbarDropdown">
                          <span class="dropdown-item"></span>
                        <a href="<?php echo e(route('auth.two.factor.toggle.form')); ?>"
                           class="dropdown-item"><?php echo app('translator')->get('auth.two factor authentication'); ?></a>
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'manager')): ?>
                        <a href="<?php echo e(route('users.index')); ?>"
                           class="dropdown-item">panel</a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?php echo e(route('auth.logout')); ?>"><?php echo app('translator')->get('auth.logout'); ?></a>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>

</nav>
<?php /**PATH /home/mohammad/web/www/auth/resources/views/partials/navbar.blade.php ENDPATH**/ ?>