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
        // 1. Создаём подписку (для примера)
        $subscription = Subscription::create([
            'client_id' => 1,
            'price'     => 300,
            'currency'  => 'AZN',
            'start_date'=> now(),
            'end_date'  => now()->addMonth(),
            'title'     => 'Тестовая подписка',
        ]);

        // 2. Создаём инвойс для подписки
        $invoice = $subscription->invoices()->create([
            'client_id'            => $subscription->client_id,
            'amount'               => $subscription->price,
            'status'               => 'pending',
            'billing_period_start' => $subscription->start_date,
            'billing_period_end'   => $subscription->end_date,
            'currency'             => $subscription->currency,
        ]);
        echo "Создан инвойс #{$invoice->id}, статус: {$invoice->status}, сумма: {$invoice->amount}, фактическая: {$invoice->factical_amount}<br>";

        // 3. Добавляем транзакции
        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 100,
            'status'     => 'success',
            'type'       => 'debit',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 100,
            'status'     => 'success',
            'type'       => 'debit',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 200,
            'status'     => 'success',
            'type'       => 'debit',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        // 4. Добавим возврат
        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 50,
            'status'     => 'success',
            'type'       => 'refund',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 150,
            'status'     => 'success',
            'type'       => 'refund',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 250,
            'status'     => 'success',
            'type'       => 'refund',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);
        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";

        $txn = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount'     => 350,
            'status'     => 'success',
            'type'       => 'debit',
            'reference'  => uniqid('TXN-'),
            'date'       => now(),
        ]);

        echo "Транзакция #{$txn->id} → type: {$txn->type}, amount: {$txn->amount}<br>";
        echo "Инвойс: статус: {$invoice->fresh()->status}, сумма: {$invoice->amount}, фактическая: {$invoice->fresh()->factical_amount}<br>";
//        $txn = Transaction::create([
//            'invoice_id' => $invoice->id,
//            'amount'     => 400,
//            'status'     => 'success',
//            'type'       => 'refund',
//            'reference'  => uniqid('TXN-'),
//            'date'       => now(),
//        ]);
//
//        echo "Транзакция #{$txn->id} → invoice_id: {$txn->invoice_id}, amount: {$txn->amount}, status: {$txn->status}, type: {$txn->type}, reference: {$txn->reference}, date: {$txn->date}<br>";
//        echo "Взяли 400 → статус: {$invoice->fresh()->status}, фактическая: {$invoice->fresh()->factical_amount}<br>";
    }
}
