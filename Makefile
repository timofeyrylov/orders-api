help:
	@echo "Available commands:"
	@echo "  make create-environment       - Creates .env file if it does not exist"
	@echo "  make start       			   - Start Docker containers"
	@echo "  make stop        			   - Stop Docker containers"
	@echo "  make down       			   - Stop and remove Docker containers, networks, and volumes"
	@echo "  make install			       - Install project dependencies"
	@echo "  make update			       - Update project dependencies"
	@echo "  make logs			           - View Docker container logs"

create-environment:
	cd docker && if [ ! -e .env ]; then cp .env.example .env; fi

start:
	cd docker && docker-compose up -d

stop:
	cd docker && docker-compose stop

down:
	cd docker && docker-compose down

install:
	docker exec php-container composer install

update:
	docker exec php-container composer update

logs:
	cd docker && docker-compose logs -f