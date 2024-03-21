<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class Otp extends Mailable
    {
        use Queueable, SerializesModels;

        public $otp;

        public function __construct($otp)
        {
            $this->otp = $otp;
        }

        public function build()
        {
            return $this->subject('Confirmation de connexion')
                        ->view('mail.otp')
                        ->with([
                            'otp' => $this->otp,
                        ]);
        }
    }
