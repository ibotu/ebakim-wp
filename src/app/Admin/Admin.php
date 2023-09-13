<?php

namespace eBakim\Admin;

use eBakim\App;

use eBakim\Admin\Screen;
use eBakim\Admin\Screen\Patients;
use eBakim\Admin\Screen\AddPatient;
use eBakim\Admin\Screen\ScrapePatientProfile;
use eBakim\Admin\Screen\Locker;
use eBakim\Admin\Screen\LockerSearch;
use eBakim\Admin\Screen\AddLocker;
use eBakim\Admin\Screen\EditLocker;
use eBakim\Admin\Screen\Medication;
use eBakim\Admin\Screen\AddMedication;
use eBakim\Admin\Screen\EditMedication;
use eBakim\Admin\Screen\PatientMedication;
class Admin
{
    private $appContext;

    public function __construct( App $appContext )
    {
        $this->appContext = $appContext;

        
            // menu
            add_action('admin_menu', [$this, 'pages']);

            // headers
            add_action('admin_menu', [$this, 'init']);

         
        if ( is_admin() ) {
            // plugins meta link shortcut
            $plugin_base = plugin_basename( $this->appContext->getPluginFile() );
            add_filter("plugin_action_links_{$plugin_base}", [ $this, 'connectionsLinkShortcut' ]);
        }

        return $this;
    }
    public function pages()
    {
       
    
        add_menu_page(
            __('eBakim ', 'ebakim-wp'),        // Sidebar menu title
            __('eBakim', 'ebakim-wp'),          // Actual page title
            'manage_options',
            'eBakim',
            [$this->getScreenObject(Patients::class), 'render'],
            'dashicons-admin-plugins',      // Dashicon for the menu
             6  
        );
       add_submenu_page(
            'eBakim',                        // Parent menu slug
            __('New Patient', 'ebakim-wp'),     // Submenu page title
            __('New Patient', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'add_patient',         // Submenu slug                  
            [$this->getScreenObject(AddPatient::class), 'render'], // Callback function to render the submenu page
            
        );
        
        add_submenu_page(
            'eBakim',                        // Parent menu slug
            __('Locker', 'ebakim-wp'),     // Submenu page title
            __('Locker', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'locker',         // Submenu slug                  
            [$this->getScreenObject(Locker::class), 'render'], // Callback function to render the submenu page
            
        );
        add_submenu_page(
            'Locker',
            __('Add New Locker', 'ebakim-wp'),     // Submenu page title
            __('Add New Locker', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'add_new_locker',
            [$this->getScreenObject(AddLocker::class ), 'render']
        );
        add_submenu_page(
            'eBakim',                        // Parent menu slug
            __('Medication', 'ebakim-wp'),     // Submenu page title
            __('Medication', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'medication',         // Submenu slug                  
            [$this->getScreenObject(Medication::class), 'render'], // Callback function to render the submenu page
            
        );
        add_submenu_page(
            'Medication',
            __('Add New Medication', 'ebakim-wp'),     // Submenu page title
            __('Add New Medication', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'add_new_medication',
            [$this->getScreenObject(AddMedication::class ), 'render']
        );
        add_submenu_page(
            'eBakim',
            __('Patient Medication', 'ebakim-wp'),     // Submenu page title
            __('Patient Medication', 'ebakim-wp'),     // Submenu menu title
            'manage_options',
            'patientmedication',
            [$this->getScreenObject(PatientMedication::class ), 'render']
        );
        
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'insert_locker',
            [$this->getScreenObject(AddLocker::class ), 'insertlocker']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'edit_locker',
            [$this->getScreenObject(EditLocker::class ), 'render']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'update_locker',
            [$this->getScreenObject(EditLocker::class ), 'updatelocker']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'delete_locker',
            [$this->getScreenObject(EditLocker::class ), 'deletelocker']
        );
        
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'insert_medication',
            [$this->getScreenObject(AddMedication::class ), 'insertmedication']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'edit_medication',
            [$this->getScreenObject(EditMedication::class ), 'render']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'update_medication',
            [$this->getScreenObject(EditMedication::class ), 'updatemedication']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'delete_medication',
            [$this->getScreenObject(EditMedication::class ), 'deletemedication']
        );
        add_submenu_page(
            '',
            null,     // Submenu page title
            null,     // Submenu menu title
            'manage_options',
            'lockersearch',
            [$this->getScreenObject(LockerSearch::class ), 'render']
        );
        remove_submenu_page('ebakim', 'ebakim');
        
    }
    private function callPageScreenMethod(string $method)
    {
        switch ($_REQUEST['page'] ?? null) {
         
                case 'eBakim':
                    return call_user_func([$this->getScreenObject(Patients::class), $method]);
                case 'add_patient':
                    return call_user_func([$this->getScreenObject(AddPatient::class), $method]);
                case 'scrape_patient_profile':
                    return call_user_func([$this->getScreenObject(ScrapePatientProfile::class), $method]);
                case 'locker':
                    return call_user_func([$this->getScreenObject(Locker::class), $method]);
                case 'lockersearch':
                        return call_user_func([$this->getScreenObject(LockerSearch::class), $method]);
                case 'add_new_locker':
                    return call_user_func([$this->getScreenObject(AddLocker::class), $method]);
                case 'edit_locker':
                    return call_user_func([$this->getScreenObject(EditLocker::class), $method]);
                case 'medication':
                    return call_user_func([$this->getScreenObject(Medication::class), $method]);
                case 'patientmedication':
                    return call_user_func([$this->getScreenObject(PatientMedication::class), $method]);
                case 'edit_medication':
                        return call_user_func([$this->getScreenObject(EditMedication::class), $method]);
        }
    }
    public function init()
    {
        return $this->callPageScreenMethod('init');
    }
    public function scripts()
    {
        return $this->callPageScreenMethod('scripts');
    }

    public function getScreenObject( string $class )
    {
        return $this->screenContext[$class] ?? ( $this->screenContext[$class] = new $class( $this->appContext ) );
    }

    public function connectionsLinkShortcut( $links )
    {
        return array_merge([
            'settings' => '<a href="admin.php?page=eBakim">' . __('Manage', 'eBakim') . '</a>'
        ], $links);
    }
}

