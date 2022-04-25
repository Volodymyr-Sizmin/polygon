<?php

namespace App\Service;

use App\Entity\VerificationRequest;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VerificationService
{
    private $validator;
    private $mailer;

    public function __construct(ValidatorInterface $validator, MailerInterface $mailer)
    {
        $this->validator = $validator;
        $this->mailer = $mailer;
    }

    public function sendEmail(VerificationRequest $verificationRequest, string $url)
    {
        $url .= $verificationRequest->getUrl();
        $to = $verificationRequest->getEmail();
        $email = (new Email())
            ->from('polygon@mail.com')
            ->to($to)
            ->subject('Verify POLYGON account')
            ->text("To activate your account go to this url: $url")
            ->html("<p>Click url to activate account</p><a href='$url'>$url</a>");

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function validate(VerificationRequest $verificationRequest)
    {
        $email = strtolower($verificationRequest->getEmail());

        $sepEmail = explode('@', $email);

        $errorsString = [];

        foreach ($sepEmail as $elem) {
            if (strlen($elem) < 3) {
                $errorsString[] = 'Invalid email address';
            }

            if (strlen($elem) > 32) {
                $errorsString[] = 'Invalid email address';
            }
        }

        $pattern = "/^[^.][a-z0-9!#$%&‘*+\/^_`{|}~\=?-]+\.?[a-z0-9!#$%&‘*+\/^_`{|}~\=?-]+[^.]@[a-z0-9-]+\.[a-z]{2,3}$/";

        if (!preg_match($pattern, $email)) {
            $errorsString[] = 'Invalid email address';
        }

        $errors = $this->validator->validate($verificationRequest);
        foreach ($errors as $error) {
            $errorsString[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorsString;
    }
}
