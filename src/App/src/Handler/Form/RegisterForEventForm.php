<?php
declare(strict_types=1);

namespace App\Handler\Form;

use Zend\Form\Element;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\Regex as RegexValidator;

/**
 * Provide the form definition to RSVP to an event
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 */
final class RegisterForEventForm extends Form
{
    public function __construct(array $eventOptions)
    {
        parent::__construct();

        $eventElement = new Element\Select('event', ['label' => 'form.event.label']);
        $eventElement->setAttribute('id', 'event');
        $eventElement->setValueOptions($eventOptions);

        $firstNameElement = new Text('firstName', ['label' => 'form.firstName.label']);
        $firstNameElement->setAttribute('id', 'firstName');
        $lastNameElement = new Text('lastName', ['label' => 'form.lastName.label']);
        $lastNameElement->setAttribute('id', 'lastName');
        $emailElement = new Element\Email('email', ['label' => 'form.email.label']);
        $emailElement->setAttribute('id', 'email');
        $emailElement->setEmailValidator(new RegexValidator(
            [
                'pattern' => '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/',
                'messages' => [RegexValidator::NOT_MATCH => 'form.email.notMatch']
            ]
        ));

        $captchaElement = new Element\Captcha('captcha', ['label' => 'form.captcha.label']);
        $captcha = new \Zend\Captcha\Dumb();
        $captcha->setLabel('');
        $captchaElement->setAttribute('id', 'captcha');
        $captchaElement->setCaptcha($captcha);

        $csrfElement = new Csrf('security');

        $sendElement = new Element('send');
        $sendElement->setValue('form.register.submit');
        $sendElement->setAttributes([
            'type' => 'submit',
        ]);

        $this->add($eventElement);
        $this->add($firstNameElement);
        $this->add($lastNameElement);
        $this->add($emailElement);
        $this->add($csrfElement);
        $this->add($sendElement);
        $this->add($captchaElement);

        $firstNameInput = new Input('firstName');
        $firstNameInput->getValidatorChain()->attach(
            new NotEmpty(['messages' => [NotEmpty::IS_EMPTY => 'form.firstName.isEmpty']])
        );

        $lastNameInput = new Input('lastName');
        $lastNameInput->getValidatorChain()->attach(
            new NotEmpty(['messages' => [NotEmpty::IS_EMPTY => 'form.lastName.isEmpty']])
        );

        $emailInput = new Input('email');
        $emailInput->getValidatorChain()->attach(
            new NotEmpty(['messages' => [NotEmpty::IS_EMPTY => 'form.email.isEmpty']])
        );

        $inputFilter = new InputFilter();
        $inputFilter->add($firstNameInput);
        $inputFilter->add($lastNameInput);
        $inputFilter->add($emailInput);

        $this->setInputFilter($inputFilter);

    }
}
