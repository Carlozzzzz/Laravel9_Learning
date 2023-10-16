
<?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $array = array('title' => 'Student System') ;?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav','data' => ['data' => $array]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($array)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <header class="max-w-lg mx-auto mt-5" >
        <a href="">
            <h1 class="text-4xl font-bold text-white text-center ">Student List</h1>

        </a>
    </header>

    <section class="mt-10">
        <div class="overflox-x-auto relative">
            <table class="w-96 mx-auto text-sm text-left text-gray-500">
                <thead class="text-xs text gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                        </th>
                        <th scope="col" class="py-3 px-6">
                            First Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Last Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            email
                        </th>
                        <th scope="col" class="py-3 px-6">
                            age
                        </th>
                        <th scope="col">

                        </th>
                    </tr>
                </thead>

                <tbody class="">
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray-800 border-b text-white">
                        
                        <?php $default_prifile = "https://api.dicebear.com/avatar.svg" ?>
                        <td class="p-1 ">
                            <img class="w-[3.5rem] h-[2.5rem] object-cover bg-gray-200" src="<?php echo e($student->student_image ? asset("storage/student/thumbnail/".$student->student_image) : $default_prifile); ?>" alt="">
                        </td>
                        <td class="py-3 px-6">
                            <?php echo e($student->first_name); ?>

                        </td>
                        <td class="py-3 px-6">
                            <?php echo e($student->last_name); ?>

                        </td>
                        <td class="py-3 px-6">
                            <?php echo e($student->email); ?>

                        </td>
                        <td class="py-3 px-6">
                            <?php echo e($student->age); ?>

                        </td>
                        <td class="py-3 px-6">
                            <a href="/student/<?php echo e($student->id); ?>" class="bg-sky-600 px-3 py-2 rounded">view</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                
            </table>
            <div class="max-w-lg mx-auto pt-6 p-4 ">
                <?php echo e($students->links()); ?>

            </div>
        </div>
    </section>

<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php /**PATH C:\xampp\htdocs\development\practice\Laravel9_Learning\laravel2\resources\views/students/index.blade.php ENDPATH**/ ?>