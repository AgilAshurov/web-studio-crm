<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function run()
    {
//        // 1. Создаём инвойс
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 300,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//
//        // 2. Поступление транзакции
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 100,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 200,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 100,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        // 4. Добавим возврат
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 200,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 350,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 40,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 320,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//
//        // 3. Создаём еще инвойс
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 500,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 100,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 600,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 500,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 500,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 500,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 200,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 500,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 600,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 100,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        $invoice = Invoice::create([
//            'client_id'            => 0,
//            'amount'               => 500,
//            'status'               => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end'   => now()
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 550,
//            'status'     => 'success',
//            'type'       => 'debit',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 40,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//
//        $subscription = Subscription::create([
//            'client_id' => 1,
//            'title' => 'Premium Plan',
//            'currency' => 'AZN',
//            'price' => 300,
//            'billing_period' => 'monthly',
//            'start_date' => now(),
//            'status' => 'active',
//        ]);
//
//        $invoiceOld = Invoice::create([
//            'subscription_id' => $subscription->id,
//            'client_id' => 1,
//            'amount' => 200,
//            'status' => 'pending',
//            'billing_period_start' => now()->subMonths(2),
//            'billing_period_end' => now()->subMonth(),
//        ]);
//
//        $invoiceNew = Invoice::create([
//            'subscription_id' => $subscription->id,
//            'client_id' => 1,
//            'amount' => 300,
//            'status' => 'pending',
//            'billing_period_start' => now(),
//            'billing_period_end' => now()->addMonth(),
//        ]);
//
//        // Эмулируем оплату
//        $subscription->applyPayment(400);
    }
}
