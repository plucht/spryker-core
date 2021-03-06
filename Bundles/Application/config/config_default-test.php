<?php

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\Kernel\KernelConstants;

$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];
$config[KernelConstants::CORE_NAMESPACES] = [
    'Spryker',
];

$config[ApplicationConstants::PROJECT_TIMEZONE] = 'UTC';
$config[KernelConstants::PROJECT_NAMESPACE] = 'Pyz';

$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL;

$config[ApplicationConstants::YVES_SSL_ENABLED] = false;
