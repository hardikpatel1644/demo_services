<?php

namespace Ixoil\EmailBundle\Model;

/**
 * Define email type 
 *
 * @author Hardik
 */
class EmailType
{
    /**
     * 
     */
    const Registration = "registration";

    /**
     * 
     */
    const ChangePassword = "changePassword";

    /**
     * 
     */
    const Login = "login";

    /**
     * 
     */
    const ForgotPassword = "forgotPassword";

    /**
     * 
     */
    const AccountAccept = "accountAccept";

    /**
     * 
     */
    const AccountReject = "accountReject";

    /**
     * 
     */
    const General = "general";
    
    /**
     * Email from contact us form.
     */
    const ContactUs = "contact_us";
    
    /**
     *  To Send email to ixoil admin on user confirm his account.
     */
    const EmailConfirmed = "email_confirmed";

    /**
     * Sending an email to newly registered company with email confirmation URL.
     */
    const ConfirmationEmail = "confirmation_email";
}

