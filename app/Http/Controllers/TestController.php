<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class TestController extends Controller
{
    public function run()
    {
        // 1. Создаём первую подписку
        $subscription = Subscription::create([
            'client_id' => 1,
            'currency'  => 'USD',
            'price'     => 300,
            'status'    => 'active',
            'start_date'=> now(),
            'end_date'  => now()->addMonth(),
            'title'     => 'Первая подписка',
        ]);

        // 2. Создаём инвойс для первой подписки
        $invoice = $subscription->invoices()->create([
            'client_id'             => $subscription->client_id,
            'amount'                => $subscription->price,
            'status'                => 'pending',
            'billing_period_start'  => $subscription->start_date,
            'billing_period_end'    => $subscription->end_date,
            'currency'              => $subscription->currency,
        ]);

        // 3. Добавляем транзакции (пример: 300 + 400 = 700)
        Transaction::create([
            'invoice_id' => $invoice->id,
            'type'       => 'debit',
            'currency'   => $subscription->currency,
            'amount'     => 300,
            'status'     => 'success',
            'reference'  => Str::uuid(),
            'date'       => now(),
        ]);

        Transaction::create([
            'invoice_id' => $invoice->id,
            'type'       => 'debit',
            'currency'   => $subscription->currency,
            'amount'     => 400,
            'status'     => 'success',
            'reference'  => Str::uuid(),
            'date'       => now(),
        ]);

        // 4. Проверяем переплату и создаём новые подписки
        $remaining = $invoice->factical_amount; // фактическая сумма = 700
        $price = $subscription->price;
        $start = Carbon::parse($subscription->end_date);

        while ($remaining > 0) {
            $amountForThis = min($remaining, $price);

            $newSubscription = Subscription::create([
                'client_id' => $subscription->client_id,
                'currency'  => $subscription->currency,
                'price'     => $price,
                'status'    => 'active',
                'start_date'=> $start,
                'end_date'  => $start->copy()->addMonth(),
                'title'     => 'Автоподписка',
            ]);

            // создаём инвойс для новой подписки
            $newSubscription->invoices()->create([
                'client_id'             => $newSubscription->client_id,
                'amount'                => $amountForThis, // если остаток меньше цены
                'status'                => $amountForThis < $price ? 'partial' : 'pending',
                'billing_period_start'  => $newSubscription->start_date,
                'billing_period_end'    => $newSubscription->end_date,
                'currency'              => $newSubscription->currency,
            ]);

            $remaining -= $amountForThis;
            $start = $start->copy()->addMonth();
        }

        return response()->json([
            'subscriptions' => Subscription::all(),
            'invoices'      => Invoice::all(),
            'transactions'  => Transaction::all(),
        ]);
    }
}
