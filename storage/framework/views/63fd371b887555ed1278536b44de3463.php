<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <?php if($product->imageUrl()): ?>
                <img src="<?php echo e($product->imageUrl()); ?>" class="img-fluid border w-100" style="max-height:480px;object-fit:cover;" alt="<?php echo e($product->name); ?>">
            <?php else: ?>
                <div class="border bg-light d-flex align-items-center justify-content-center" style="height:360px;">No image</div>
            <?php endif; ?>
        </div>
        <div class="col-lg-6">
            <h1 class="mb-2"><?php echo e($product->name); ?></h1>
            <div class="price fs-3 mb-3">BDT <?php echo e(number_format($product->price, 2)); ?></div>
            <p class="mb-3"><?php echo e($product->description); ?></p>
            <p class="text-muted">Available stock: <strong><?php echo e($product->stock); ?></strong></p>

            <?php if($product->isInStock()): ?>
                <form method="POST" action="<?php echo e(route('cart.add', $product)); ?>" class="row g-2 align-items-end">
                    <?php echo csrf_field(); ?>
                    <div class="col-auto">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" class="form-control" style="width:100px;">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-accent">Add to Cart</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">Out of stock</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/shop/products/show.blade.php ENDPATH**/ ?>