<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

use Magento\Framework\Stdlib\DateTime;
use Magento\Security\Model\PasswordResetRequestEvent;
use Magento\Security\Model\PasswordResetRequestEventFactory;
use Magento\Security\Model\ResourceModel\PasswordResetRequestEvent as PasswordResetRequestEventResource;
use Magento\TestFramework\Helper\Bootstrap;

if ($this->moduleManager->isEnabled('Magento_Customer')) {
    require __DIR__ . '/../../../Magento/Customer/_files/customer.php';

    $objectManager = Bootstrap::getObjectManager();
    /** @var PasswordResetRequestEventFactory $passwordResetRequestEventFactory */
    $passwordResetRequestEventFactory = $objectManager->get(PasswordResetRequestEventFactory::class);
    /** @var PasswordResetRequestEventResource $passwordResetRequestEventResource */
    $passwordResetRequestEventResource = $objectManager->get(PasswordResetRequestEventResource::class);

    $dateTime = new DateTimeImmutable();
    $passwordResetRequestEvent = $passwordResetRequestEventFactory->create();
    $passwordResetRequestEvent->setRequestType(PasswordResetRequestEvent::CUSTOMER_PASSWORD_RESET_REQUEST)
        ->setAccountReference('customer@example.com')
        ->setIp(ip2long('127.0.0.1'))
        ->setCreatedAt($dateTime->modify('-5 minutes')->format(DateTime::DATETIME_PHP_FORMAT))->save();
    $passwordResetRequestEventResource->save($passwordResetRequestEvent);
}
