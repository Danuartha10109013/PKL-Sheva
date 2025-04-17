<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // To store the dynamic data

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Penagihan pembayaran Invoice'. 
        $this->data['invoiceId']. ' untuk '. $this->data['term'] .' Proyek '. 
        $this->data['projectName'] .' dari PT ZEN MULTIMEDIA INDONESIA')
                    ->view('page.finance.emails.invoice')
                    ->with('customerName', $this->data['customerName'])
                    ->with('invoiceId', $this->data['invoiceId'])
                    ->with('amount', $this->data['amount'])
                    ->with('dueDate', $this->data['dueDate'])
                    ->with('senderName', $this->data['senderName'])
                    ->with('company', $this->data['company'])
                    ->with('term', $this->data['term'])
                    ->with('percentage', $this->data['percentage'])
                    ->with('terbilang', $this->data['terbilang'])
                    ->with('projectName', $this->data['projectName'])
                    ->with('npwp', $this->data['npwp'])
                    ->with('ppn', $this->data['ppn'])
                    ->with('alamat', $this->data['alamat'])
                    ->with('totalCostNoPpn', $this->data['totalCostNoPpn'])
                    ->with('totalCost', $this->data['totalCost']);
    }
}
