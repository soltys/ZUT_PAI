@echo off

setlocal

SET NAME=psoltysiak
SET ZIPNAME=PAI_PROJECT_%NAME%.zip

SET sevenZipPath=%PROGRAMW6432%\7-Zip
set PATH=%PATH%;%sevenZipPath%

del %ZIPNAME%

cd document
call make_pdf
cd ..
copy document\opis_projektu_PAI.pdf opis_projektu_PAI.pdf


7z a -mx9 -tzip %ZIPNAME% code opis_projektu_PAI.pdf

del opis_projektu_PAI.pdf
