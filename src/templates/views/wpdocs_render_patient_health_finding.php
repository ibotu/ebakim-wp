<?php defined('WPINC') || exit; ?>
<?php
include(dirname(__FILE__) . '/../header.php');

global $wpdb;

$health_finding = $wpdb->prefix . 'eb_health_finding';
$data = $wpdb->get_row("
    SELECT {$health_finding}.id AS health_finding_id, wp_users.id AS user_id, {$health_finding}.*, wp_users.*
    FROM {$health_finding}
    INNER JOIN wp_users ON {$health_finding}.health_personnel = wp_users.id
    WHERE {$health_finding}.id = {$_GET['id']}
", OBJECT);

?>

<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <h1 style="padding:9px 9px 9px 0"><?php _e('eBakim &lsaquo; Patient Health Finding', 'ebakim-wp'); ?></h1>
    </div>

    <!-- Display Patient Health Finding Data -->
    <div class="patient-data row">
        <div class="col-md-6 col-sm-12 col-12">


            <style>
                .patient-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .patient-table th,
                .patient-table td {
                    padding: 8px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }

                .patient-table tr:nth-child(even) {
                    background-color: #f2f2f2;
                    /* Even rows have a different background color */
                }
            </style>

            <table class="patient-table">
            <tr>
                <!-- <th>Health Finding ID</th>
                    <td><?php echo $data->health_finding_id; ?></td>
                </tr>
                <tr>
                    <th>User ID</th>
                    <td><?php echo $data->user_id; ?></td>
                </tr> -->
                <tr>
                    <th>ID</th>
                    <td><?php echo $data->id; ?></td>
                </tr>
                <tr>
                    <th>History</th>
                    <td><?php echo $data->history; ?></td>
                </tr>
                <tr>
                    <th>Moment</th>
                    <td><?php echo $data->moment; ?></td>
                </tr>
                <tr>
                    <th>Fever °C</th>
                    <td><?php echo $data->fever; ?></td>
                </tr>
                <tr>
                    <th>Pulse</th>
                    <td><?php echo $data->nabiz; ?></td>
                </tr>
                <tr>
                    <th>High/Low Blood Pressure</th>
                    <td><?php echo $data->blood_pressure; ?></td>
                </tr>
                <tr>
                    <th>SPO2%</th>
                    <td><?php echo $data->spo2; ?></td>
                </tr>
                <tr>
                    <th>Health Personnel</th>
                    <td><?php echo $data->health_personnel; ?></td>
                </tr>
                <tr>
                    <th>ID</th>
                    <td><?php echo $data->ID; ?></td>
                </tr>
                <tr>
                    <th>User Login</th>
                    <td><?php echo $data->user_login; ?></td>
                </tr>
                <tr>
                    <th>User Email</th>
                    <td><?php echo $data->user_email; ?></td>
                </tr>
                <tr>
                    <th>User Registered</th>
                    <td><?php echo $data->user_registered; ?></td>
                </tr>
                <tr>
                    <th>User Activation Key</th>
                    <td><?php echo $data->user_activation_key; ?></td>
                </tr>
                <tr>
                    <th>User Status</th>
                    <td><?php echo $data->user_status; ?></td>
                </tr>
                <tr>
                    <th>Display Name</th>
                    <td><?php echo $data->display_name; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include((dirname(__FILE__) . '/../') . 'footer.php'); ?>