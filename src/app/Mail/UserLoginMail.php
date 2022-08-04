<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLoginMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * User
     *
     * @var User
     * */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Login notification')
            ->markdown('emails.user.login', [
                'name' => $this->user->first_name,
                'ip' => request()->ip(),
                'login_at' => $this->user->last_login_at->format('d-M-Y h:i A'),
            ]);
    }
}
