<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class Reservation extends Mailable
    {
        use Queueable, SerializesModels;

        public $exam;

        public function __construct($exam)
        {
            $this->exam = $exam;
        }

        public function build()
        {
            return $this->subject('Nouvelle prise de resarvation')
                        ->view('mail.reservation')
                        ->with([
                            'exam' => $this->exam,
                        ]);
        }
    }
