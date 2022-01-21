<?php $basket = app('App\Support\Basket\Basket'); ?>
<div class="card bg-light">
	<div class="card-body">
		<h4><?php echo app('translator')->get('payment.cart summary'); ?></h4>
		<hr>
		<div class="well">
			<table class='table'>
				<tr>
					<td><?php echo app('translator')->get('payment.item total'); ?></td>
					<td><?php echo e(number_format($basket->subTotal())); ?> <?php echo app('translator')->get('payment.toman'); ?></td>
				</tr>
				<tr>
					<td><?php echo app('translator')->get('payment.shipping'); ?></td>
					<td><?php echo e(number_format(10000)); ?>  <?php echo app('translator')->get('payment.toman'); ?></td>
				</tr>
				<tr>
					<td><?php echo app('translator')->get('payment.basket total'); ?></td>
					<td><?php echo e(number_format($basket->subTotal() + 10000)); ?> <?php echo app('translator')->get('payment.toman'); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<?php /**PATH /home/mohammad/web/www/auth/resources/views/summary.blade.php ENDPATH**/ ?>