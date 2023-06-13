<?php

namespace Drzl\Commands;

use Drzl\Processes\Docker;

class ServerBootstrap extends BaseCommand
{
    protected $signature = 'server:bootstrap';

    protected $description = 'Set up Docker to run Drzl apps';

    public function handle()
    {
        $this->manifest->servers()->each(function (string $server) {
             if (Docker::on($server)->isInstalled()->successful()) {
                $this->info("Docker is already installed on {$server}");
                
                return;
            }

            if (Docker::on($server)->hasSuperuserPermissions()->failed()) {
                $this->error("Docker is not installed on {$server} and can\'t be automatically installed without having root access. Install Docker manually: https://docs.docker.com/engine/install/");
                
                exit(self::FAILURE);
            }

            $this->comment("Missing Docker on {$server}. Installing...");
            
            $this->withOutput(Docker::on($server), function ($docker) {
                $docker->install();
            });

            $this->info("Docker has been installed on {$server}.");
        });
    }
}
