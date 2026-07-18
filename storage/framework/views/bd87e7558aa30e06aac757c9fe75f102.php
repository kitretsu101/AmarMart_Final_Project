<?php $__env->startSection('title', 'AmarMart'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero">
    <div class="container">
        <div class="col-lg-7">
            <div class="hero-brand">AmarMart</div>
            <h1 class="h3 fw-normal mb-3">Everyday essentials, managed with care.</h1>
            <p class="lead mb-4">Browse products, add to cart, and checkout with automatic Oracle-backed invoices.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-accent btn-lg px-4">Shop Products</a>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 mb-1">Featured Products</h2>
            <p class="text-muted mb-0">Selected items currently available in stock.</p>
        </div>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary">View all</a>
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-3">
                <div class="border bg-white h-100">
                    <?php if($product->imageUrl()): ?>
                        <img src="<?php echo e($product->imageUrl()); ?>" class="product-thumb" alt="<?php echo e($product->name); ?>">
                    <?php else: ?>
                        <div class="product-thumb d-flex align-items-center justify-content-center text-muted">No image</div>
                    <?php endif; ?>
                    <div class="p-3">
                        <h3 class="h5"><?php echo e($product->name); ?></h3>
                        <div class="price mb-2">BDT <?php echo e(number_format($product->price, 2)); ?></div>
                        <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-am">Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-light border">No products yet. Add some from the admin panel.</div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/shop/home.blade.php ENDPATH**/ ?>