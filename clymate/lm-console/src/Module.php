<?php

namespace LmConsole;

class Module
{
    public function getConfig(): array
    {
        $configProvider = new ConfigProvider();

        return [
            'laminas-cli' => $configProvider->getCliConfig()
        ];
    }
}