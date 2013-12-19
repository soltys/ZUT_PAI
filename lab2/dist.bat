@echo off

setlocal

SET LABNR=2
SET FNAME=p
SET LNAME=soltysiak
SET ZIPNAME=PAI_LAB%LABNR%_%FNAME%.%LNAME%.zip

SET sevenZipPath=%PROGRAMW6432%\7-Zip
set PATH=%PATH%;%sevenZipPath%

del %ZIPNAME%

cd mysql_document
call make_pdf
cd ..
copy mysql_document\mysql.pdf mysql.pdf

cd mysql_document
call make_pdf
cd ..
copy mysql_document\mysql.pdf mysql.pdf

cd mod_rewrite_document
call make_pdf
cd ..
copy mod_rewrite_document\mod_rewrite.pdf mod_rewrite.pdf

7z a -mx9 -tzip %ZIPNAME% projekt-01-01 zad7 zad6 mysql.pdf mod_rewrite.pdf

del mysql.pdf
del mod_rewrite.pdf