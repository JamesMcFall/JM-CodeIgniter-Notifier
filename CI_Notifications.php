<?php
/**
 * CI_Notifications Class:
 * =======================
 * This class is designed to be extended in a new project-specific notifications
 * class, where all the project speficif properties will be set up in the 
 * constructor and then the individual notification emails will be defined as 
 * methods.
 * 
 * @author James McFall <james@mcfall.geek.nz>
 * @date 8 February 2013
 * @version V0.1
 */
namespace JM;
class CI_Notifications {
       
    # Email API Configuration
    protected $_emailFromAddress    = null;
    protected $_emailFromName       = null;
    protected $_emailReplyToAddress = null;
    
    /**
     * This function uses the built in CodeIgniter email class to send email
     * notifications. 
     * 
     * @param <string> $to - Email address of recipient
     * @param <string> $subject - Email subject
     * @param <string> $htmlMessage - HTML version of the email message
     * @param <string> $plainTextMessage - Plaintext fallback email message
     * @param <string> $attachmentPath - Attachment path relative to document root of app
     */
    protected function _sendEmailNotification($to, $subject, $htmlMessage, $plainTextMessage, $ccTo = '', $attachmentPath = false) {
        
        $CI = &get_instance();
        
        # If the email library is not loaded, load it up
        if (!isset($CI->email)) {
            $CI->load->library('email');
        }
        
        # Not sure if this is required, but set the mailtype to HTML
        $CI->email->initialize(array('mailtype' => 'html'));

        # Set up message details
        $CI->email->from($this->_emailFromAddress, $this->_emailFromName);
        $CI->email->to($to);
        $CI->email->cc($ccTo);
        #$CI->email->bcc('');
        $CI->email->reply_to($this->_emailReplyToAddress);
        $CI->email->subject($subject);
        $CI->email->message($htmlMessage);
        $CI->email->set_alt_message($plainTextMessage);
        
        # If there is an attachment supplied, attach it to the email
        if ($attachmentPath) {
            $CI->email->attach(APP_ROOT . $attachmentPath);
        }
        
        $sent = $CI->email->send();

        # Uncomment if you want to see the debugging output.
        # $CI->email->print_debugger();
        
        # Clear the email from memory so that i.e. attachments etc aren't sent 
        # to emails sent after this.
        $CI->email->clear(TRUE);  
        
        if ($sent) {
            return true;
        }
        
        return false;
    }
}