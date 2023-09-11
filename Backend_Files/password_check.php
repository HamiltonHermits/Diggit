<?php

/**
 * Server side function to check password strength
 * 
 * Variables Used:
 *   - $password: Password to be queried.

 * 
 * @return array An associative array with password strenght status.
 */
function isPasswordStrong($password)
{
    // Check if the password is at least 8 characters long
    if (strlen($password) < 8) {
        return array('strong_password' => false, 'error' => 'Password needs to be at least 8 characters long');
    }

    // Check if the password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return array('strong_password' => false, 'error' => 'Password needs to contain at least one uppercase letter');
    }

    // Check if the password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return array('strong_password' => false, 'error' => 'Password needs to contain at least one lowercase letter');
    }

    // Check if the password contains at least one digit
    if (!preg_match('/[0-9]/', $password)) {
        return array('strong_password' => false, 'error' => 'Password needs to contain at least one digit');
    }

    //removed because excessive
    // // Check if the password contains at least one special character (e.g., !, @, #, $, %)
    // if (!preg_match('/[!@#\$%]/', $password)) {
    //     return array('strong_password'=> false,'error' => 'Password needs to be');
    // }

    // Password meets all strength requirements
    return array('strong_password' => true);
}
