<?php

namespace eBakim;

use eBakim\Admin\Admin;

use WP_User;

class App
{
    private $plugin_file;
    private $adminContext;
    private $consumer;

    const SCRIPTS_VERSION = 1659280235;
    const DB_VERSION = 0.1;
    const DB_VERSION_OPTION = 'ebakim:db_version';
    const PATIENTS_TABLE = 'eb_patients';
    const SERVICES_TABLE = 'eb_services';

    public function __construct( string $plugin_file )
    {
        $this->plugin_file = $plugin_file;
        $this->adminContext = new Admin( $this );
    }

    public function getPluginFile() : string
    {
        return $this->plugin_file;
    }

    public function setup()
    {
        add_action('plugins_loaded', [ $this, 'loaded' ]);

        // activation
        register_activation_hook( $this->getPluginFile(), [ $this, 'activation' ]);

        // deactivation
        register_deactivation_hook( $this->getPluginFile(), [ $this, 'deactivation' ]);

        // custom cron schedule
        add_filter('cron_schedules', [ $this, 'cronInterval' ]);

        // auto-update checker
        // $this->initAutoUpdates();
    }

}