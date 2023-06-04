.PHONY: build
build:
	@docker build -t drzl:latest -f .docker/Dockerfile .