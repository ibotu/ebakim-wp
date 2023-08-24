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

    public function __construct(string $plugin_file)
    {
        $this->plugin_file = $plugin_file;
        $this->adminContext = new Admin($this);
    }

    public function getPluginFile(): string
    {
        return $this->plugin_file;
    }


    public function setup()
    {
        add_action('plugins_loaded', [$this, 'loaded']);

        // activation
        register_activation_hook($this->getPluginFile(), [$this, 'activation']);

        // deactivation
        register_deactivation_hook($this->getPluginFile(), [$this, 'deactivation']);

        // custom cron schedule
        add_filter('cron_schedules', [$this, 'cronInterval']);

        // auto-update checker
        // $this->initAutoUpdates();
    }

   
    // Callback function to render the plugin page
    function custom_plugin_page() {
        echo '<div class="wrap">';
        echo '<h1>Custom Plugin Page</h1>';
        echo '<p>This is a sample plugin page content.</p>';
        echo '</div>';
    }
    
    public function activation()
    {
        $patient = new \eBakim\Patients();  // Instantiate the Patients class
        $patient->setupDb(self::DB_VERSION); // Call the setupDb function
    }

    public function menuPageCallback()
    {
        // Content for your menu page
        echo '<div class="wrap">';
        echo '<h2>eBakim Patients</h2>';
        // Display your plugin settings or content here
        echo '</div>';
    }


    public function deactivation()
    {
        // Code to run when the plugin is deactivated
    }


    public function cronInterval($schedules)
    {
        $schedules['custom_interval'] = array(
            'interval' => 3600, // Interval in seconds (e.g., every hour)
            'display'  => __('Custom Interval')
        );
        return $schedules;
    }

    public function loaded()
    {
        define('MY_PLUGIN_VERSION', '1.0.0');
    }

    public function customInitFunction()
    {
    }
}
