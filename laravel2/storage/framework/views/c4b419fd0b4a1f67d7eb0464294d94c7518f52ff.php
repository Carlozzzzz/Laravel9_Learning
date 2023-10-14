

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($name); ?> Document</title>
</head>
<body>
    <h2><?php echo e($name); ?></h2>
    <span><?php echo e($age); ?></span><br>
    <span><?php echo e($email); ?></span><br>
    <span><?php echo e($id); ?></span>

    <p><?php echo e(print_r($data)); ?></p>

</body>
</html><?php /**PATH C:\xampp\htdocs\development\practice\Laravel9_Learning\laravel2\resources\views/user.blade.php ENDPATH**/ ?>