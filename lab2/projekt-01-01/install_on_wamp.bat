@setlocal enableextensions
@cd /d "%~dp0"
@echo off
REM must run on elevated privileges

SET WAMPDIR=c:\wamp\www
SET SYMLINK=pai2
SET TARGET=%cd%

cd %WAMPDIR%
if not exist %SYMLINK%
mklink /D %SYMLINK% %TARGET%

rem installed
pause