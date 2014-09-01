
all:
	rm -rf ../files/*
	rm -f *.png
	curl -f -O https://www.google.de/images/srpr/logo11w.png
	curl -f -X GET http://localhost:8080/
	curl -f -X POST --data-binary @logo11w.png http://localhost:8080/foo/logo.png
	curl -f -X GET http://localhost:8080/
	curl -f -X GET http://localhost:8080/foo/
	curl -f -X GET http://localhost:8080/foo/logo.png > get_logo.png
	curl -f -X PUT --data-binary @logo11w.png http://localhost:8080/foo/logo.png
	curl -f -X DELETE http://localhost:8080/foo/logo.png
	curl -f -X GET http://localhost:8080/foo/
