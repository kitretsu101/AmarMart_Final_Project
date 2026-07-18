<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'AmarMart'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --am-ink: #1c2430;
            --am-navy: #243b55;
            --am-accent: #c45c26;
            --am-sand: #f3efe8;
            --am-line: #d9d2c5;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            color: var(--am-ink);
            background: linear-gradient(180deg, #f7f4ef 0%, #ffffff 40%, #f7f4ef 100%);
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, h6, .navbar-brand { font-family: "Times New Roman", Times, serif; }
        .navbar-am {
            background: rgba(255,255,255,.92);
            border-bottom: 1px solid var(--am-line);
        }
        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: .02em;
            color: var(--am-navy) !important;
        }
        .btn-am {
            background: var(--am-navy);
            border-color: var(--am-navy);
            color: #fff;
        }
        .btn-am:hover { background: #1a2c40; border-color: #1a2c40; color: #fff; }
        .btn-accent {
            background: var(--am-accent);
            border-color: var(--am-accent);
            color: #fff;
        }
        .btn-accent:hover { background: #a84c1d; border-color: #a84c1d; color: #fff; }
        .hero {
            min-height: calc(100vh - 72px);
            background:
                linear-gradient(105deg, rgba(28,36,48,.78) 0%, rgba(36,59,85,.45) 45%, rgba(28,36,48,.25) 100%),
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            color: #fff;
            display: flex;
            align-items: center;
        }
        .hero-brand {
            font-size: clamp(3rem, 8vw, 5.5rem);
            font-weight: 700;
            line-height: 1;
            margin-bottom: .75rem;
        }
        .product-thumb {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: var(--am-sand);
        }
        .footer-am {
            border-top: 1px solid var(--am-line);
            background: #fff;
        }
        .price { color: var(--am-accent); font-weight: 700; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-am sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">AmarMart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#shopNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="shopNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.index')); ?>">Products</a></li>
            </ul>
            <form class="d-flex me-3" action="<?php echo e(route('products.search')); ?>" method="GET">
                <input class="form-control me-2" type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search products">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <a class="btn btn-am" href="<?php echo e(route('cart.index')); ?>">
                <i class="bi bi-cart3"></i> Cart (<?php echo e($cartCount ?? 0); ?>)
            </a>
        </div>
    </div>
</nav>

<?php if(session('success') || session('error') || $errors->any()): ?>
    <div class="container mt-3">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php echo $__env->yieldContent('content'); ?>

<footer class="footer-am py-4 mt-5">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <div><strong>AmarMart</strong> — Mini E-Commerce Management</div>
        <a href="<?php echo e(route('admin.login')); ?>" class="text-decoration-none text-muted">Admin Login</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH H:\Girhub local\AmarMart_Final_Project\resources\views/layouts/shop.blade.php ENDPATH**/ ?>