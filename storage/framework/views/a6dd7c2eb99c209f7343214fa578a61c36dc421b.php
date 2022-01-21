<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
	<div class="col-md-6 mt-5">
		<?php echo $__env->make('partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
	<div class="card-body">
		<div class="row mb-5">
			<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4 mb-5 ">
				<div class="card" style="width: 18rem;">
				<img class="card-img-top" src="<?php echo e($product->image); ?>" alt="Card image cap">
					<div class="card-body">
					<h5 class="card-title"><?php echo e($product->title); ?></h5>
						<p class="card-text"> <?php echo e($product->description); ?> </p>
					<a href="<?php echo e(route('basket.add', $product->id)); ?>" class="btn btn-primary"><?php echo app('translator')->get('payment.add to basket'); ?></a>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mohammad/web/www/auth/resources/views/products.blade.php ENDPATH**/ ?>