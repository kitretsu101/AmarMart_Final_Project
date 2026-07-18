<?php $__env->startSection('title', $q ? 'Search: '.$q : 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h2 mb-1"><?php echo e($q ? 'Search results' : 'All Products'); ?></h1>
        <p class="text-muted mb-0">
            <?php if($q): ?>
                Showing matches for “<?php echo e($q); ?>”
            <?php else: ?>
                Browse the AmarMart catalog.
            <?php endif; ?>
        </p>
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
                        <h2 class="h5"><?php echo e($product->name); ?></h2>
                        <div class="price mb-1">BDT <?php echo e(number_format($product->price, 2)); ?></div>
                        <div class="small text-muted mb-3">Stock: <?php echo e($product->stock); ?></div>
                        <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-am">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-light border">No products found.</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/shop/products/index.blade.php ENDPATH**/ ?>