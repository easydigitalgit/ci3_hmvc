<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('doHashPassword'))
{
    function doHashPassword($plainPassword)
    {
       // return password_hash($plainPassword, PASSWORD_DEFAULT);
          return password_hash($plainPassword, PASSWORD_ARGON2I, array('cost'=>22));

    }
}

if(!function_exists('doHashPassword2'))
{
    function doHashPassword2($plainPassword)
    {
       // return password_hash($plainPassword, PASSWORD_DEFAULT);
          return password_hash($plainPassword, PASSWORD_DEFAULT);

    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}
