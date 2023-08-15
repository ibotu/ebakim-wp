<?php defined('ABSPATH') || exit; ?>

<div class="wrap">
    <h2><?php echo $patient
        ? __('eBakim &lsaquo; Edit Patient', 'ebakim')
        : __('eBakim &lsaquo; Add Patient', 'ebakim'); ?></h2>

    <form method="post" style="max-width:600px">
        <?php foreach ( [
            'tcNumber' => __('TC Number', 'ebakim'),
            'id' => __('Patient ID', 'ebakim'),
            'number' => __('Patient Number', 'ebakim'),
            'firstName' => __('Patient Firstname', 'ebakim'),
            'lastName' => __('Patient Lastname', 'ebakim'),
            'gender' => __('Patient Lastname', 'ebakim'),
            'firstName' => __('First Name', 'ebakim'),
            'lastName' => __('Last Name', 'ebakim'),
            'fatherName' => __('Father Name', 'ebakim'),
            'motherName' => __('Mother Name', 'ebakim'),
            'nationality' => __('Nationality', 'ebakim'),
            'serialNumber' => __('Passport Number', 'ebakim'),
            'birthdate' => __('Birth Date', 'ebakim'),
            'birthplace' => __('Birth Place', 'ebakim'),
            'length' => __('Length', 'ebakim'),
            'weight' => __('Weight', 'ebakim'),
            'bloodtype' => __('Blood Type', 'ebakim'),
            'education' => __('Education', 'ebakim'),
            'occupation' => __('Occupation', 'ebakim'),
            'socialsecurity' => __('Social Security', 'ebakim'),
            'allergy' => __('Allergy', 'ebakim'),
            'picture' => __('Picture', 'ebakim'),
            'email' => __('Email', 'ebakim'),
            'phoneNumber' => __('Phone Number', 'ebakim'),
            'address' => __('Address', 'ebakim'),
            'streetName' => __('Street Name', 'ebakim'),
            'province' => __('Province', 'ebakim'),
            'city' => __('City', 'ebakim'),
            'responsiblePsychologist' => __('Responsible Psychologist', 'ebakim'),
            'responsibleNurse' => __('Responsible Nurse', 'ebakim'),
            'assignedGroup' => __('Assigned Group', 'ebakim'),
            'assignedProfile' => __('Assigned Profile', 'ebakim'),
            'customProfile' => __('Custom Profile', 'ebakim'),
            'acceptanceDate' => __('Acceptance Date', 'ebakim'),
            'acceptanceLocation' => __('Acceptance Location', 'ebakim'),
            'arrivalMethod' => __('Arrival Method', 'ebakim'),
            'identityIdentification' => __('Identity Identification', 'ebakim'),
            'speakingAbility' => __('Speaking Ability', 'ebakim'),
            'hearingAbility' => __('Hearing Ability', 'ebakim'),
            'visualAbility' => __('Visual Ability', 'ebakim'),
            'personalDiseases' => __('Personal Diseases', 'ebakim'),
            'familyDiseases' => __('Family Diseases', 'ebakim'),
            'accidentsAndSurgeries' => __('Accidents And Surgeries', 'ebakim'),
            'constantlyUsed' => __('Contantly Used', 'ebakim'),
            'usedMedicine' => __('Used Medicine', 'ebakim'),
            'harmfulHabits' => __('Harmful Habits', 'ebakim'),
            'addictionStatus' => __('Addiction Status', 'ebakim'),
            'mentalState' => __('Mental State', 'ebakim'),
            'evaluatedHealthPersonnel' => __('Evaluated Health Personnels', 'ebakim'),

            'email' => __('Patient email', 'ebakim'),
            'phone' => __('Patient phone', 'ebakim'),
            'address' => __('Patient address', 'ebakim'),
            'insurer' => __('Patient Insurer', 'ebakim'),
            'policy' => __('Patient Policy', 'ebakim'),
            'UZOVI' => __('UZOVI', 'ebakim'),
            'location' => __('Location', 'ebakim'),
            'practitioner' => __('Practitioner', 'ebakim'),
            'status' => __('Status', 'ebakim'),
        ] as $prop => $name ) : ?>
            <p>
                <label>
                    <strong style="display:table;margin-bottom:5px"><?php echo esc_attr($name); ?></strong>
                    
                    <input type="text" class="widefat" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>" <?php echo $patient && 'id' == $prop ? 'disabled="disabled"' : ''; ?> />
                </label>
            </p>
        <?php endforeach; ?>
            <p>
                    <label>
                        <strong style="display:table;margin-bottom:5px"><?php echo esc_attr($name); ?></strong>
                        
                        <input type="text" class="widefat" name="<?php echo esc_attr($prop); ?>" value="<?php echo esc_attr($_POST[$prop] ?? ''); ?>" <?php echo $patient && 'id' == $prop ? 'disabled="disabled"' : ''; ?> />
                    </label>
                </p>



        <p>
            <input type="hidden" name="_wpnonce" value="<?php echo esc_attr($nonce); ?>">
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'ebakim'); ?>">
        </form>
        </p>
</div>