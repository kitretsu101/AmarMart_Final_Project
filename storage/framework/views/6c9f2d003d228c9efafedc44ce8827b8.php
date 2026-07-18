<?php $__env->startSection('title', 'Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="h2 mb-4">Shopping Cart</h1>

    <?php if($items->isEmpty()): ?>
        <div class="alert alert-light border">Your cart is empty. <a href="<?php echo e(route('products.index')); ?>">Browse products</a></div>
    <?php else: ?>
        <div class="table-responsive bg-white border">
            <table class="table mb-0 align-middle">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th style="width:140px;">Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item['product']->name); ?></td>
                        <td>BDT <?php echo e(number_format($item['product']->price, 2)); ?></td>
                        <td>
                            <form method="POST" action="<?php echo e(route('cart.update', $item['product'])); ?>" class="d-flex gap-1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="0" max="<?php echo e($item['product']->stock); ?>" class="form-control form-control-sm">
                                <button class="btn btn-sm btn-outline-secondary">Update</button>
                            </form>
                        </td>
                        <td>BDT <?php echo e(number_format($item['subtotal'], 2)); ?></td>
                        <td>
                            <form method="POST" action="<?php echo e(route('cart.remove', $item['product'])); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <form method="POST" action="<?php echo e(route('cart.clear')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-outline-secondary">Clear Cart</button>
            </form>
            <div class="text-end">
                <div class="fs-4 mb-2">Total: <span class="price">BDT <?php echo e(number_format($total, 2)); ?></span></div>
                <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-accent btn-lg">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/shop/cart/index.blade.php ENDPATH**/ ?>