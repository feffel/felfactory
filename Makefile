build:
	docker build . -t felfactory
bash:
	docker run -it --rm  -v ${PWD}:/app felfactory bash
shell:
	docker run -it --rm  -v ${PWD}:/app felfactory psysh vendor/autoload.php
