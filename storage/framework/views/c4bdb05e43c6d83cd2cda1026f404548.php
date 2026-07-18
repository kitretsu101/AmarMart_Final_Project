<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="h2 mb-4">Checkout</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <form method="POST" action="<?php echo e(route('checkout.store')); ?>" class="border bg-white p-4">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="customer_address" rows="3" class="form-control" required><?php echo e(old('customer_address')); ?></textarea>
                </div>
                <button class="btn btn-accent">Place Order</button>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="border bg-white p-4">
                <h2 class="h5 mb-3">Order Summary</h2>
                <ul class="list-unstyled mb-3">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="d-flex justify-content-between mb-2">
                            <span><?php echo e($item['product']->name); ?> × <?php echo e($item['quantity']); ?></span>
                            <span>BDT <?php echo e(number_format($item['subtotal'], 2)); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                    <strong>Total</strong>
                    <strong class="price">BDT <?php echo e(number_format($total, 2)); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/shop/checkout/index.blade.php ENDPATH**/ ?>