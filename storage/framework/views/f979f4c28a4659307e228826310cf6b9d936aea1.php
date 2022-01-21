<?php $__env->startSection('content'); ?>


    <div class="justify-content-center mt-5">
        <div class="row">
            <?php echo $__env->make('partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php if($items->isEmpty()): ?>
            <p><?php echo app('translator')->get('payment.empty basket', ['link' => route('product.index')]); ?></p>

        <?php else: ?>


            <div class="row">
                <div class="col-md-7 card bg-light mr-3">
                    <div class="card-body well">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('payment.product name'); ?></th>
                                <th><?php echo app('translator')->get('payment.product price'); ?></th>
                                <th><?php echo app('translator')->get('payment.quantity'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->title); ?></td>
                                    <td>  <?php echo e(number_format($item->price)); ?> <?php echo app('translator')->get('payment.toman'); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('basket.update', $item->id)); ?>" method="post" class="form-inline">
                                            <?php echo csrf_field(); ?>
                                            <select name="quantity" id="quantity" class="form-control input-sm mr-sm-2">
                                                <?php for($i =  0; $i <= $item->stock; $i++): ?>
                                                    <option <?php if($item->quantity == $i): ?> selected <?php endif; ?> value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm"><?php echo app('translator')->get('payment.update'); ?></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php echo $__env->make('summary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <a href="<?php echo e(route('basket.checkout.form')); ?>" class="btn mt-4   btn-primary btn-lg w-100 d-block"><?php echo app('translator')->get('payment.confirm and continue'); ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mohammad/web/www/auth/resources/views/basket.blade.php ENDPATH**/ ?>