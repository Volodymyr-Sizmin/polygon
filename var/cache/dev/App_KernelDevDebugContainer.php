<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container7tJdQXA\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container7tJdQXA/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container7tJdQXA.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container7tJdQXA\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container7tJdQXA\App_KernelDevDebugContainer([
    'container.build_hash' => '7tJdQXA',
    'container.build_id' => 'e56db47d',
    'container.build_time' => 1664521169,
], __DIR__.\DIRECTORY_SEPARATOR.'Container7tJdQXA');
