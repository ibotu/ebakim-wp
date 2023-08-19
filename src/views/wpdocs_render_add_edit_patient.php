<?php defined('ABSPATH') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
if (isset($_GET['id'])) {
    global $wpdb;
    $eb_patients = $wpdb->prefix . 'eb_patients';
    $patient_id = intval($_GET['id']); // Sanitize and convert to integer

    // Retrieve patient data for the specified ID
    $patient_data = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $eb_patients WHERE id = %d", $patient_id)
    );
}

$has_guardian_value = (isset($patient_data) && $patient_data->has_guardian === 'yes') ? 'yes' : 'no';

$health_insurance_values = [];
if (isset($patient_data) && isset($patient_data->health_insurance)) {
    $decoded_health_insurance = json_decode($patient_data->health_insurance);
    $health_insurance_values = is_array($decoded_health_insurance) ? $decoded_health_insurance : [];
}

$identification_sign_values = [];
if (isset($patient_data) && isset($patient_data->identification_sign)) {
    $decoded_identification_sign = json_decode($patient_data->identification_sign);
    $identification_sign_values = is_array($decoded_identification_sign) ? $decoded_identification_sign : [];
}

?>
<style>
    input {
        width: 100%;
    }

    .flowers {
        width: 35px;
        height: 35px;
    }

    .flex-div {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="wrap">
    <h2><?= (isset($patient_data)) ? __('Edit Patient', 'ebakim-wp') : __('Add Patient', 'ebakim-wp') ?></h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" style="max-width: 600px">
        <input type="hidden" name="action" value="<?= ((isset($patient_data)) ? 'edit_patient' : 'add_patient') ?>" />
        <?php
        if (isset($_GET['id'])) {
        ?>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />


        <?php } ?>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('FirstName', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="first_name" value="<?php echo esc_attr($patient_data->first_name ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Last Name', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="last_name" value="<?php echo esc_attr($patient_data->last_name ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('TC Number', 'ebakim-wp'); ?></strong>
            <input required type="number" name="tc_number" value="<?php echo esc_attr($patient_data->tc_number ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Gender', 'ebakim-wp'); ?></strong>
            <label><input type="radio" checked name="gender" value="male" <?php checked('male', $patient_data->gender ?? ''); ?>> <?php echo __('Male', 'ebakim-wp'); ?></label>
            <label><input type="radio" name="gender" value="female" <?php checked('female', $patient_data->gender ?? ''); ?>> <?php echo __('Female', 'ebakim-wp'); ?></label>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Date of Birth', 'ebakim-wp'); ?></strong>
            <input required type="date" name="date_of_birth" value="<?php echo date("Y-m-d", strtotime(esc_attr($patient_data->date_of_birth ?? ''))) ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Picture', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*" name="picture">

            <!-- <div class="main_image_container">
            <div class="d-flex" style="gap:5px;">
                <input type="file" accept="image/*" name="profile_image" class="imageInput form-control file-selected">
            </div>

            <div class="preview-container">
                <img style="width: 100px; height:100px;    border: 1px solid lightgrey; border-radius:3px;" class="imagePreview" src="https://www.touchtaiwan.com/images/default.jpg">
                <button type="button" class="btn btn-danger clear-button" style="opacity: 0;">Clear</button>
            </div>
        </div> -->


        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Email', 'ebakim-wp'); ?></strong>
            <input required type="email" class="widefat" name="email" value="<?php echo esc_attr($patient_data->email ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Phone', 'ebakim-wp'); ?></strong>
            <input required type="tel" name="phone" value="<?php echo esc_attr($patient_data->phone ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Address', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="address" value="<?php echo esc_attr($patient_data->address ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Street', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="street" value="<?php echo esc_attr($patient_data->street ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Province', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="province" value="<?php echo esc_attr($patient_data->province ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('City', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="city" value="<?php echo esc_attr($patient_data->city ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Health Insurance', 'ebakim-wp'); ?></strong>
            <label><input type="checkbox" name="health_insurance[]" value="SGK" <?php checked(in_array('SGK', $health_insurance_values)); ?>> <?php echo __('SGK', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="GSS" <?php checked(in_array('GSS', $health_insurance_values)); ?>> <?php echo __('GSS', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="ASPIM" <?php checked(in_array('ASPIM', $health_insurance_values)); ?>> <?php echo __('ASPIM', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="Foreign" <?php checked(in_array('Foreign', $health_insurance_values)); ?>> <?php echo __('Foreign', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="Speech_Bubble" <?php checked(in_array('Speech_Bubble', $health_insurance_values)); ?>> <?php echo __('Speech Bubble', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="Greencard" <?php checked(in_array('Greencard', $health_insurance_values)); ?>> <?php echo __('Greencard', 'ebakim-wp'); ?></label><br>
            <label><input type="checkbox" name="health_insurance[]" value="Other" id="otherCheckbox" <?php checked(in_array('Other', $health_insurance_values)); ?>> <?php echo __('Other', 'ebakim-wp'); ?></label><br>
            <input type="text" name="other_health_insurance" id="otherHealthInsurance" placeholder="<?php echo esc_attr__('Other', 'ebakim-wp'); ?>" value="<?php echo esc_attr($patient_data->other_health_insurance ?? ''); ?>">
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const otherCheckbox = document.getElementById('otherCheckbox');
                    const otherHealthInsurance = document.getElementById('otherHealthInsurance');

                    otherHealthInsurance.style.display = otherCheckbox.checked ? 'block' : 'none';

                    otherCheckbox.addEventListener('change', function() {
                        otherHealthInsurance.style.display = this.checked ? 'block' : 'none';
                        if (!this.checked) {
                            otherHealthInsurance.value = '';
                        }
                    });
                });
            </script>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Arrival Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="arrival_date" value="<?php echo esc_attr($patient_data->arrival_date ?? ''); ?>">
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Has Guardian', 'ebakim-wp'); ?></strong>
            <label><input type="radio" name="has_guardian" value="yes" <?php checked($has_guardian_value, 'yes'); ?>> <?php echo __('Yes', 'ebakim-wp'); ?></label>
            <label><input type="radio" name="has_guardian" value="no" <?php checked($has_guardian_value, 'no'); ?>> <?php echo __('No', 'ebakim-wp'); ?></label>
        </p>

        <div id="guardian_fields" style="display: <?php echo ($has_guardian_value === 'yes') ? 'block' : 'none'; ?>;">
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Guardian Name', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" name="guardian_name" value="<?php echo esc_attr($patient_data->guardian_name ?? ''); ?>">
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Guardian Email', 'ebakim-wp'); ?></strong>
                <input type="email" class="widefat" name="guardian_email" value="<?php echo esc_attr($patient_data->guardian_email ?? ''); ?>">
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Guardian Number', 'ebakim-wp'); ?></strong>
                <input type="tel" name="guardian_number" value="<?php echo esc_attr($patient_data->guardian_number ?? ''); ?>">
            </p>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const hasGuardianRadio = document.getElementsByName("has_guardian");
                const guardianFields = document.getElementById("guardian_fields");

                hasGuardianRadio.forEach(function(radio) {
                    radio.addEventListener("change", function() {
                        guardianFields.style.display = this.value === "yes" ? "block" : "none";
                    });
                });


            });
        </script>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Identification Sign', 'ebakim-wp'); ?></strong>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image1.png') ?>" alt="image1" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Pembe_Yonca" <?php checked(in_array('Pembe_Yonca', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Pembe Yonca --- No Sugary Foods (meaning)', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image2.png') ?>" alt="image2" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Purple_Clover" <?php checked(in_array('Purple_Clover', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Purple Clover --- No Salty Foods', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image3.png') ?>" alt="image3" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Green_Clover_Leaf" <?php checked(in_array('Green_Clover_Leaf', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Green Clover Leaf --- Tripping Risk', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image4.png') ?>" alt="image4" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Black_Clover" <?php checked(in_array('Black_Clover', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Black Clover --- Suicide Risk', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image5.png') ?>" alt="image5" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Speech_Bubble" <?php checked(in_array('Speech_Bubble', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Speech Bubble --- Mental Illness', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image6.png') ?>" alt="image6" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="San_Triangle" <?php checked(in_array('San_Triangle', $identification_sign_values)); ?>>
            <label>
                <?php echo __('San Triangle --- Radiation Therapy', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image7.png') ?>" alt="image7" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Red_Star" <?php checked(in_array('Red_Star', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Red Star --- Risk of Contact Infection', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image8.png') ?>" alt="image8" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="Blue_Flower" <?php checked(in_array('Blue_Flower', $identification_sign_values)); ?>>
            <label>
                <?php echo __('Blue Flower --- Risk of Transmission via Drip', 'ebakim-wp'); ?>
            </label>
        </div>
        <div class="flex-div">
            <img class="flowers" src="<?= plugins_url('/ebakim/src/assets/images/image9.png') ?>" alt="image9" width="500" height="600">
            <input type="checkbox" name="identification_sign[]" value="San_Leaf" <?php checked(in_array('San_Leaf', $identification_sign_values)); ?>>
            <label>
                <?php echo __('San Leaf --- Risk of Respiratory Contamination', 'ebakim-wp'); ?>
            </label>
        </div>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Suicide Risk', 'ebakim-wp'); ?></strong>
            <input type="text" name="suicide_risk" value="<?php echo esc_attr($patient_data->suicide_risk ?? ''); ?>">
        </p>
        <p>
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'ebakim-wp'); ?>">
        </p>
    </form>
</div>

<?php include(__DIR__ . '/../templates/footer.php'); ?>