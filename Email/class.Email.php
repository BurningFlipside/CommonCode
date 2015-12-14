<?php
/**
 * Email class
 *
 * This file describes the Email class
 *
 * PHP version 5 and 7
 *
 * @author Patrick Boyd / problem@burningflipside.com
 * @copyright Copyright (c) 2015, Austin Artistic Reconstruction
 * @license http://www.apache.org/licenses/ Apache 2.0 License
 */

namespace Email;

/**
 * An class to represent an email
 */
class Email extends \SerializableObject
{
    /** The email's sender */
    protected $sender;
    /** An array of receipients */
    protected $to;
    /** An array of CC receipients */
    protected $cc;
    /** An array of BCC receipients */
    protected $bcc;
    /** The email's reply to address */
    protected $replyTo;
    /** The subject of the email */
    protected $subject;
    /** The email's HTML body */
    protected $htmlBody;
    /** The email's plain text body */
    protected $textBody;
    /** An array of attachements for the email */
    protected $attachments;

    /**
     * Initialize a new email
     */
    public function __construct()
    {
        $this->sender = false;
        $this->to = array();
        $this->cc = array();
        $this->bcc = array();
        $this->replyTo = false;
        $this->subject = false;
        $this->htmlBody = '';
        $this->textBody = '';
        $this->attachments = array();
    }

    /**
     * Who is this email going to be sent from
     *
     * This will return a string either in the format of 'email@address' or 'name <email@address>'
     *
     * @return string The sender of the email
     */
    public function getFromAddress()
    {
        if($this->sender === false)
        {
            return 'Burning Flipside <webmaster@burningflipside.com>';
        }
        return $this->sender;
    }

    /**
     * Who is this email going to
     *
     * @return array The recipients of the email
     */
    public function getToAddresses()
    {
        return $this->to;
    }

    /**
     * Who is this email going to (CC)
     *
     * @return array The recipients of the email
     */
    public function getCCAddresses()
    {
        return $this->cc;
    }

    /**
     * Who is this email going to (BCC)
     *
     * @return array The recipients of the email
     */
    public function getBCCAddresses()
    {
        return $this->bcc;
    }

    /**
     * Who should a recipient reply to?
     *
     * @return string The reply to address of the email
     */
    public function getReplyTo()
    {
        if($this->replyTo === false)
        {
            return $this->getFromAddress();
        }
        return $this->replyTo;
    }

    /**
     * What is the email's subject?
     *
     * @return string The email's subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * What should a user with an HTML capable email client see?
     *
     * @return string The email in HTML form
     */
    public function getHTMLBody()
    {
        return $this->htmlBody;
    }

    /**
     * What should a user with a plain text only email client see?
     *
     * @return string The email in ASCII form
     */
    public function getTextBody()
    {
        return $this->textBody;
    }

    /**
     * Set the address the email should be sent from
     *
     * @param string $email The email address to send from
     * @param string $name  The name to associate with the from address
     */
    public function setFromAddress($email, $name=false)
    {
        if($name !== false)
        {
            $this->sender = $name.' <'.$email.'>';
        }
        else
        {
            $this->sender = $email;
        }
    }

    /**
     * Add a new address to the To: line
     *
     * @param string $email The email address to send to
     * @param string $name  The name to associate with the address
     */
    public function addToAddress($email, $name=false)
    {
        $this->addAddress($this->to, $email, $name);
    }

    /**
     * Add a new address to the CC: line
     *
     * @param string $email The email address to send to
     * @param string $name  The name to associate with the address
     */
    public function addCCAddress($email, $name=false)
    {
        $this->addAddress($this->cc, $email, $name);
    }

    /**
     * Add a new address to the BCC: line
     *
     * @param string $email The email address to send to
     * @param string $name  The name to associate with the address
     */
    public function addBCCAddress($email, $name=false)
    {
        $this->addAddress($this->bcc, $email, $name);
    }

    /**
     * Add an address to the inidicated list
     *
     * @param array  $list  The list to add the address to
     * @param string $email The email address to send to
     * @param string $name  The name to associate with the address
     */
    protected function addAddress(&$list, $email, $name=false)
    {
        $address = $email;
        if($name !== false)
        {
            $address = $name.' <'.$email.'>';
        }
        array_push($list, $address);
    }

    /**
     * Set the address a recipient should reply to
     *
     * @param string $email The email address to reply to
     * @param string $name  The name to associate with the from address
     */
    public function setReplyTo($email, $name=false)
    {
        if($name !== false)
        {
            $this->replyTo = $name.' <'.$email.'>';
        }
        else
        {
            $this->replyTo = $email;
        }
    }

    /**
     * Set the subject line for the email
     *
     * @param string $subject The email's new subject line
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Set the HTML body for the email
     *
     * @param string $body The email's new HTML body
     */
    public function setHTMLBody($body)
    {
        $this->htmlBody = $body;
    }

    /**
     * Set the plain text for the email
     *
     * @param string $body The email's new plain text body
     */
    public function setTextBody($body)
    {
        $this->textBody = $body;
    }

    /**
     * Append a string to the HTML Body
     *
     * @param string $body The string to append to the HTML body
     */
    public function appendToHTMLBody($body)
    {
        $this->htmlBody.= $body;
    }

    /**
     * Append a string to the Plain Text Body
     *
     * @param string $body The string to append to the plain text body
     */
    public function appendToTextBody($body)
    {
        $this->textBody.= $body;
    }

    /**
     * Add an attachment from a memory buffer
     *
     * @param string $name The file name for the attachment to be sent as
     * @param string $buffer The attachment as a binary string
     * @param string $mimeType The MIME type to send the attachment as
     */
    public function addAttachmentFromBuffer($name, $buffer, $mimeType = 'application/octet-stream')
    {
        array_push($this->attachments, array('name'=>$name, 'data'=>$buffer, 'mimeType'=>$mimeType));
    }

    /**
     * Add an attachment from a file on the local disk
     *
     * @param string $filename The file name and path on the local disk
     * @param string $name The file name for the attachment to be sent as
     */
    public function addAttachmentFromFile($filename, $name = false)
    {
        if($name === false)
        {
            $name = basename($filename);
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filename);
        if($mimeType === false)
        {
            if(file_exists($filename) && is_file($filename) && is_readable($filename))
            {
                $this->addAttachmentFromBuffer($name, file_get_contents($filename));
            }
        }
        else
        {
            $this->addAttachmentFromBuffer($name, file_get_contents($filename), $mimeType);
        }
    }

    /**
     * Does this email have an attachment?
     *
     * @return boolean True if the email has an attachment. False otherwise
     */
    public function hasAttachments()
    {
        return empty($this->attachments) !== true;
    }

    /**
     * Serialize the message to a raw MIME encoded format suitable for sending over SMTP
     *
     * @return string A text version of the message suitable for sending over SMTP
     */
    public function getRawMessage()
    {
        $boundary = uniqid(rand(), true);
        $raw_message = 'To: '.$this->encodeRecipients($this->getToAddresses())."\n";
        $raw_message.= 'From: '.$this->encodeRecipients($this->getFromAddress())."\n";
        if(!empty($this->cc))
        {
            $raw_message.= 'CC: '. $this->encodeRecipients($this->getCCAddresses())."\n";
        }
        if(!empty($this->bcc))
        {
            $raw_message.= 'BCC: '. $this->encodeRecipients($this->getBCCAddresses())."\n";
        }
        $raw_message .= 'Subject: '.$this->getSubject()."\n";
        $raw_message .= 'MIME-Version: 1.0'."\n";
        $raw_message .= 'Content-type: Multipart/Mixed; boundary="'.$boundary.'"'."\n";
        $raw_message .= "\n--{$boundary}\n";
        $raw_message .= 'Content-type: Multipart/Alternative; boundary="alt-'.$boundary.'"'."\n";
        $text_body    = $this->getTextBody();
        if($text_body !== false && strlen($text_body) > 0)
        {
            $raw_message.= "\n--alt-{$boundary}\n";
            $raw_message.= "Content-Type: text/plain\n\n";
            $raw_message.= $text_body."\n";
        }
        $html_body    = $this->getHTMLBody();
        if($html_body !== false && strlen($html_body) > 0)
        {
            $charset = empty($this->messageHtmlCharset) ? '' : "; charset=\"{$this->messageHtmlCharset}\"";
            $raw_message .= "\n--alt-{$boundary}\n";
            $raw_message .= 'Content-Type: text/html; charset="UTF-8"'."\n\n";
            $raw_message .= $html_body."\n";
        }
        $raw_message.= "\n--alt-{$boundary}--\n";
        foreach($this->attachments as $attachment)
        {
            $raw_message.= "\n--{$boundary}\n";
            $raw_message.= 'Content-Type: '. $attachment['mimeType'].'; name="'.$attachment['name']."\"\n";
            $raw_message.= 'Content-Disposition: attachment'."\n";
            $raw_message.= 'Content-Transfer-Encoding: base64'."\n\n";
            $raw_message.= chunk_split(base64_encode($attachment['data']), 76, "\n")."\n";
        }
        $raw_message .= "\n--{$boundary}--\n";
        return $raw_message;
    }

    /**
     * Serialize a recipient so that it can be sent over SMTP
     *
     * @param string $recipient The recipient in the format 'name <email@address>'
     *
     * @return string A text version of the recipient name and address suitable for sending over SMTP
     */
    public function encodeRecipients($recipient)
    {
        if(is_array($recipient))
        {
            return join(', ', array_map(array($this, 'encodeRecipients'), $recipient));
        }
        if(preg_match("/(.*)<(.*)>/", $recipient, $regs))
        {
            $recipient = '=?UTF-8?B?'.base64_encode($regs[1]).'?= <'.$regs[2].'>';
        }
        return $recipient;
    }
}
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
?>
