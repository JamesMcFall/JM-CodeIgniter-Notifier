JM-CodeIgniter-Notifier
=======================

This code is designed to make it very easy to have a centralized notifications handler for your CodeIgniter application. 

The idea is that you can have html email templates as individual html files making it easy for front end developers to design and build, while providing a simple means for us back end guys to send rich html emails (with attachments).

The included _CI_Notifications_ class is essentially an extendible wrapper for the CodeIgniter email helper.

## Installation
### Setting up the classes
Simply copy the **CI_Notifications** class file and the **Example_Notifications** class file to your **application/libraries/** folder (rename the Example_Notifications file and class to whatever you want). From there you'll want to add it to the autoloader ( **application/config/autoload.php** ) in the libraries array like below:

```php
$autoload['libraries'] = array("CI_Notifications", "Example_Notifications");
```

### Create an email template directory
Each notification email is an html file on its own. We need a directory to store them in, so I normally create **./public/email-templates/** in which I store the template files and their assets (normally all stored in a sub directory).

### Configuring your notifications class
There are a few variables **in the constructor of your notifications class** that will now need setting up.

```php
# Email Configuration
$this->_emailFromAddress    = 'no_reply@mysite.com';
$this->_emailFromName       = 'My Site Admin';
$this->_emailReplyToAddress = 'no_reply@mysite.com';
$this->_emailTemplateDir    = 'public/email-templates/';
```
    
## Usage
Now that your classes are configured, you can set up a method to send a notification. The below examples is taken from the Example_Notifications class.
    
```php
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
                'Plaintext goes here.', # Optional
                'Attachment.txt' # Optional
            ); 
}
```
    
Once you have set up your notifications as above, you can send out your notification email from your code with ease.

```php
# Create an instance of the notifications handler and send the welcome email
$notificationHandler = new Example_Notifications();
$notificationHandler->sendWelcomeEmail("Billybob", "asd123", "billybob@gmail.com");
```

Or since it's auto-loaded it'll be available like this:

```php
# Create an instance of the notifications handler and send the welcome email
$this->example_notifications->sendWelcomeEmail("Billybob", "asd123", "billybob@gmail.com");
```
