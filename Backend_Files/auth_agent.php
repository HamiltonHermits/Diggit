<?php 


function validatePhoneNumber($phoneNumber) {
    // Define a regular expression pattern to match the desired format
    $pattern = '/^\d{3} \d{3} \d{4}$/';
    
    // Use the preg_match() function to check if the phone number matches the pattern
    if (preg_match($pattern, $phoneNumber)) {
        return [
            'authenticated' => true,
        ];
    } else {
        return [
            'authenticated' => false,
            'error' => 'Has to be in the form of xxx xxx xxxx',
        ];
    }
}


?>