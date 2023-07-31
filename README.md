[![tests](https://github.com/drzled/drzl/actions/workflows/tests.yml/badge.svg)](https://github.com/drzled/drzl/actions/workflows/tests.yml)

# DRZL
DRZL is a Laravel package that simplifies the deployment process for web applications. It allows you to deploy your application anywhere, from bare metal servers to cloud VMs, using Docker with zero downtime. By leveraging the dynamic reverse-proxy Traefik, DRZL can hold requests while the new application container is started and the old one is stopped. It works seamlessly across multiple hosts, using Symfony Process component to execute commands. With DRZL, you can deploy your Laravel applications with ease, without worrying about the underlying infrastructure.

This will:
- Connect to the servers over SSH (using root by default, authenticated by your ssh key)
- Install Docker on any server that might be missing it (using apt-get): root access is needed via ssh for this.
- Log into the registry both locally and remotely
- Build the image using the standard Dockerfile in the root of the application.
- Push the image to the registry.
- Pull the image from the registry onto the servers.
- Ensure Traefik is running and accepting traffic on port 80.
- Ensure your app responds with 200 OK to GET /up (you must have curl installed inside your app image!).
- Start a new container with the version of the app that matches the current git version hash.
- Stop the old container running the previous version of the app.
- Prune unused images and stopped containers to ensure servers don't fill up.

Voila! All the servers are now serving the app on port 80. If you're just running a single server, you're ready to go. If you're running multiple servers, you need to put a load balancer in front of them.

## Installation

Installing DRZL is a simple process that can be completed in just a few steps. Before you begin, make sure you have `PHP 8.1+` or higher installed on your system.

**The first step** is to require DRZL as a `dev` dependency in your project by running the following command on your command line.

```bash
composer require drzled/drzl --dev --with-all-dependencies
```

**Secondly**, you'll need to publish DRZL config file in your current Laravel project. This step will create a configuration file named `.drzl/drzl.yml` at the root folder of your Laravel project, which will enable you to fine-tune your infraestucture later.

```bash
drzl init
```

Then, edit the new file `.drzl/drzl.php`. It could look as simple as this:
```yaml
name: Drzl
servers:
    - 129.168.0.1
    - 129.168.0.2
```
**Finally** you need add some environment variables on your `.env` file. 
```bash
DRZL_DOCKER_REGISTER_SERVER="ghcr.io"
LARKS_DOCKER_REGISTRY_USER="drzl"
LARKS_DOCKER_REGISTRY_PASSWORD="[your-personal-access-token]"
```
Please, ensure to set the right value for each variable. 

# Run CLI Using Docker

```bash
eval `ssh-agent -s` && echo ${SSH_PRIVATE_KEY} | ssh-add - > /dev/null
```

```bash
alias drzl="docker run --rm -it --user $UID:1000 -v /var/run/docker.sock:/var/run/docker.sock -v ${PWD}:/app -v "${SSH_AUTH_SOCK}:${SSH_AUTH_SOCK}" -e SSH_AUTH_SOCK=${SSH_AUTH_SOCK} drzl"
```

Now you're ready to deploy to the servers:
```bash
drzl deploy
```

## Dev on Codespace

SSH Agent
```
eval `ssh-agent -s` && echo ${SSH_PRIVATE_KEY} | ssh-add - > /dev/null
```