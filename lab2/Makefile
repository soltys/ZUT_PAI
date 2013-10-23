LABNR=2
FNAME=p
LNAME=soltysiak
ZIPNAME = PAI_LAB$(LABNR)_$(FNAME).$(LNAME).zip
all dist:

dist: 
	rm -f $(ZIPNAME)
	zip $(ZIPNAME) projekt-01-01/ zad7/

clean:
	rm -f $(ZIPNAME)
	rm -rf *~

.PHONY: dist