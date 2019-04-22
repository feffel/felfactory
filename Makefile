build:
	docker build . -t felfactory
bash:
	make build
	docker run -it --rm  -v ${PWD}:/app felfactory bash
