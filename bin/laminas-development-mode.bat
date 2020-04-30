@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/laminas/laminas-development-mode/bin/laminas-development-mode
php "%BIN_TARGET%" %*
