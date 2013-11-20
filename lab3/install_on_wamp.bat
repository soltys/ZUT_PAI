@setlocal enableextensions
@cd /d "%~dp0"
@echo off
REM must run on elevated privileges

SET WAMPDIR=c:\wamp\www
SET SYMLINK=pai3
SET TARGET=%cd%

cd %WAMPDIR%

mklink /D %SYMLINK% %TARGET%

rem installed
pause