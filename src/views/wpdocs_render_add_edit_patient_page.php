<?php defined('ABSPATH') || exit; ?>
<?php include(__DIR__ . '/../templates/header.php'); ?>

<div class="wrap">
    <h2><?php echo (isset($patient))
            ? __('eBakim &lsaquo; Edit Patient', 'ebakim')
            : __('eBakim &lsaquo; Add Patient', 'ebakim'); ?></h2>

    <form method="post"  action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" style="max-width: 600px">
    <input type="hidden" name="action" value="add_patient" />

        <?php foreach ([

            'first_name' => __('First Name', 'ebakim'),
            'last_name' => __('Last Name', 'ebakim'),
            'tc_number' => __('TC Number', 'ebakim'),
            'gender' => __('Gender', 'ebakim'),
            'date_of_birth' => __('Date of Birth', 'ebakim'),
            'picture' => __('Picture', 'ebakim'),
            'email' => __('Email', 'ebakim'),
            'phone' => __('Phone', 'ebakim'),
            'address' => __('Address', 'ebakim'),
            'street' => __('Street', 'ebakim'),
            'province' => __('Province', 'ebakim'),
            'city' => __('City', 'ebakim'),
            'health_insurance' => __('Health Insurance', 'ebakim'),
            'arrival_date' => __('Arrival Date', 'ebakim'),
            'has_guardian' => __('Has Guardian', 'ebakim'),
            'guardian_name' => __('Guardian Name', 'ebakim'),
            'guardian_email' => __('Guardian Email', 'ebakim'),
            'guardian_number' => __('Guardian Number', 'ebakim'),
            'identification_sign' => __('Identification Sign', 'ebakim'),
            'suicide_risk' => __('Suicide Risk', 'ebakim'),
        ] as $prop => $name) : ?>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo esc_attr($name); ?></strong>
                <?php
                if ($prop === 'gender') {
                    // Radio buttons for gender
                ?>
                    <label><input type="radio" name="<?php echo esc_attr($prop); ?>" value="male" <?php checked('male', $_POST[$prop] ?? ''); ?>> Male</label>
                    <label><input type="radio" name="<?php echo esc_attr($prop); ?>" value="female" <?php checked('female', $_POST[$prop] ?? ''); ?>> Female</label>
                <?php
                } elseif ($prop === 'date_of_birth') {
                    // Date input for date of birth
                ?>
                    <input type="date" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>">
                <?php
                } elseif ($prop === 'picture') {
                    // Input for picture
                ?>
                    <input type="file" accept="image/*"  name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>">
                <?php
                } elseif ($prop === 'health_insurance') {
                ?>

                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="SGK" <?php checked(in_array('SGK', $_POST[$prop] ?? [])); ?>> SGK</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="GSS" <?php checked(in_array('GSS', $_POST[$prop] ?? [])); ?>> GSS</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="ASPIM" <?php checked(in_array('ASPIM', $_POST[$prop] ?? [])); ?>> ASPIM</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Foreign" <?php checked(in_array('Foreign', $_POST[$prop] ?? [])); ?>> Foreign</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Speech_Bubble" <?php checked(in_array('Speech_Bubble', $_POST[$prop] ?? [])); ?>> Speech Bubble</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Greencard" <?php checked(in_array('Greencard', $_POST[$prop] ?? [])); ?>> Greencard</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Other" id="otherCheckbox" <?php checked(in_array('Other', $_POST[$prop] ?? [])); ?>> Other</label><br>
                    <input type="text" name="<?php echo esc_attr($prop); ?>[]" id="otherHealthInsurance" placeholder="Other" value="<?php echo esc_attr($_POST['other_health_insurance'] ?? ''); ?>">
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const otherCheckbox = document.getElementById('otherCheckbox');
                            const otherHealthInsurance = document.getElementById('otherHealthInsurance');
                            
                            otherHealthInsurance.style.display = otherCheckbox.checked ? 'block' : 'none';
                            
                            otherCheckbox.addEventListener('change', function() {
                                otherHealthInsurance.style.display = this.checked ? 'block' : 'none';
                                if (!this.checked) {
                                    otherHealthInsurance.value = ''; // Clear the value when unchecked
                                }
                            });
                        });
                    </script>
                <?php
                } elseif ($prop === 'arrival_date') {
                    // Select dropdown for arrival method
                ?>
                    <input type="date" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>">
                <?php
                } elseif ($prop === 'has_guardian') {
                    // Radio buttons for has guardian
                ?>
                    <label><input type="radio" name="<?php echo esc_attr($prop); ?>" value="yes" <?php checked('yes', $_POST[$prop] ?? ''); ?>> Yes</label>
                    <label><input type="radio" checked name="<?php echo esc_attr($prop); ?>" value="no" <?php checked('no', $_POST[$prop] ?? ''); ?>> No</label>
                <?php
                } elseif ($prop === 'identification_sign') {
                    // Checkboxes for identification sign
                ?>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Pembe_Yonca" <?php checked(in_array('Pembe_Yonca', $_POST[$prop] ?? [])); ?>> Pembe Yonca --- No Sugary Foods (meaning)</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Purple_Clover" <?php checked(in_array('Purple_Clover', $_POST[$prop] ?? [])); ?>> Purple Clover --- No Salty Foods</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Green_Clover_Leaf" <?php checked(in_array('Green_Clover_Leaf', $_POST[$prop] ?? [])); ?>> Green Clover Leaf --- Tripping Risk</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Black_Clover" <?php checked(in_array('Black_Clover', $_POST[$prop] ?? [])); ?>> Black Clover --- Suicide Risk</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Speech_Bubble" <?php checked(in_array('Speech_Bubble', $_POST[$prop] ?? [])); ?>> Speech Bubble --- Mental Illness</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="San_Triangle" <?php checked(in_array('San_Triangle', $_POST[$prop] ?? [])); ?>> San Triangle --- Radiation Therapy</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Red_Star" <?php checked(in_array('Red_Star', $_POST[$prop] ?? [])); ?>> Red Star --- Risk of Contact Infection</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="Blue_Flower" <?php checked(in_array('Blue_Flower', $_POST[$prop] ?? [])); ?>> Blue Flower --- Risk of Transmission via Drip</label><br>
                    <label><input type="checkbox" name="<?php echo esc_attr($prop); ?>[]" value="San_Leaf" <?php checked(in_array('San_Leaf', $_POST[$prop] ?? [])); ?>> San Leaf --- Risk of Respiratory Contamination</label><br>

                <?php
                } elseif ($prop === 'suicide_risk') {
                    // Text input for suicide risk
                ?>
                    <input type="text" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>">
                <?php
                } else {
                    // Default text input
                ?>
                    <input type="text" class="widefat" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>">
                <?php
                }
                ?>
            </p>
        <?php endforeach; ?>
        <p>
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'ebakim'); ?>">
        </p>
    </form>
</div>