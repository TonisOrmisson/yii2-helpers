<?php

namespace andmemasin\helpers;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

final class YiiLogger extends AbstractLogger
{
    public function log($level, $message, array $context = []): void
    {
        $yiiLevel = match ($level) {
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR => \yii\log\Logger::LEVEL_ERROR,
            LogLevel::WARNING => \yii\log\Logger::LEVEL_WARNING,
            LogLevel::DEBUG => \yii\log\Logger::LEVEL_TRACE,
            default => \yii\log\Logger::LEVEL_INFO,
        };

        \Yii::getLogger()->log((string) $message, $yiiLevel, __CLASS__);
    }
}
