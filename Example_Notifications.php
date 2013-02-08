<?php
/**
 * This is an example of extending the CI_Notifications class for a specific
 * project, defining seperate methods for each of the notification emails used
 * in the project.
 * 
 * @author James McFall <james@mcfall.geek.nz>
 * @date 30 March 2012
 * @version V1.0
 */
class Example_Notifications extends JM\CI_Notifications {

    # Used to pull in the email templates
    protected $_emailTemplateDir = null;
    protected $_siteUrl          = null;
    
    /**
     * Set up all the fields from the parent AHCD_Notifications library object.
     */
    public function __construct() {
        
        # Email Configuration
        $this->_emailFromAddress    = 'no_reply@mysite.com';
        $this->_emailFromName       = 'My Site Admin';
        $this->_emailReplyToAddress = 'no_reply@mysite.com';
        $this->_emailTemplateDir    = 'public/email-templates/';
        
        # This is used for image/link paths etc.
        $this->_siteUrl = 'http://' . $_SERVER['HTTP_HOST'];
    }
    
    /**
     * This is an example method that sends a welcome email out.
     * 
     * @param <string> $name
     * @param <string> $password
     * @param <string> $emailAddress 
     * return <boolean>
     */
    public function sendWelcomeEmail($name, $password, $emailAddress) {
        
        # Read in template contents
        $template = file_get_contents($this->_emailTemplateDir . 'welcome-email.html');
        
        # Replace template variables
        $template = str_replace('{name}', $name, $template);
        $template = str_replace('{email}', $emailAddress, $template);
        $template = str_replace('{password}', $password, $template);
        $template = str_replace('{site_url}', $this->_siteUrl, $template);
                
        # Send the email
        return parent::_sendEmailNotification(
                    $emailAddress, 
                    "Welcome to the the internets.", 
                    $template, 
                    'Plaintext goes here.'
                ); 
    }
    
    /**
     * This is an example method for sending an email notifying a user that 
     * their password was updated.
     * 
     * @param <string> $name
     * @param <string> $password
     * @param <string> $emailAddress
     * @return <boolean> 
     */
    public function sendUpdatedPasswordEmail($name, $password, $emailAddress) {
        # Read in template contents
        $template = file_get_contents($this->_emailTemplateDir . 'password-updated-email.html');
        
        # Replace template variables
        $template = str_replace('{name}', $name, $template);
        $template = str_replace('{email}', $emailAddress, $template);
        $template = str_replace('{password}', $password, $template);
        $template = str_replace('{site_url}', $this->_siteUrl, $template);
                
        # Send the email
        return parent::_sendEmailNotification(
                    $emailAddress, 
                    "Your password has been updated.", 
                    $template, 
                    'Plaintext goes here.'
                ); 
    }
}