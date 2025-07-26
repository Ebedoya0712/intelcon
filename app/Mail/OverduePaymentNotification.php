<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class OverduePaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $daysOverdue;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->daysOverdue = \Carbon\Carbon::parse($payment->month_paid)
            ->endOfMonth()
            ->diffInDays(now());
    }

    public function build()
    {
        return $this->subject('Recordatorio de Pago Atrasado')
            ->markdown('emails.overdue-payment')
            ->with([
                'payment' => $this->payment,
                'daysOverdue' => $this->daysOverdue
            ]);
    }
}