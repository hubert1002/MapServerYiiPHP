<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PushForm extends CFormModel
{



    public $title;
    public $contact_name;
    public $contact_mobile;
//    public $lat,$lon;
//    public $radius,$address,$order_id,$order_description,$alias_id,$tags_id,$unit,$amend_lat,$amend_lon;






    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('title', 'required'),
            // email has to be a valid email address
            array('contact_name,contact_mobile', 'safe'),
            // verifyCode needs to be entered correctly
//            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
//            'verifyCode'=>'Verification Code',
        );
    }
}