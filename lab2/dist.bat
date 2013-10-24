@echo off

setlocal

SET LABNR=2
SET FNAME=p
SET LNAME=soltysiak
SET ZIPNAME=PAI_LAB%LABNR%_%FNAME%.%LNAME%.zip

SET sevenZipPath=%PROGRAMW6432%\7-Zip
set PATH=%PATH%;%sevenZipPath%

del %ZIPNAME%

7z a -mx9 -tzip %ZIPNAME% projekt-01-01 zad7