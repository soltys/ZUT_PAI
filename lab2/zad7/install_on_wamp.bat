@setlocal enableextensions
@cd /d "%~dp0"
@echo off
REM must run on elevated privileges

SET WAMPDIR=c:\wamp\www
SET SYMLINK=pai2_7
SET TARGET=%cd%\cakephp

cd %WAMPDIR%

mklink /D %SYMLINK% %TARGET%

rem installed
pause