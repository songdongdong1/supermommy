<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
use \Magento\Framework\Component\ComponentRegistrar;
//\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('mytheme');
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::THEME,
    'frontend/Mommy/base',
    __DIR__
);