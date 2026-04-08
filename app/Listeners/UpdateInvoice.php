<?php
//
//namespace App\Listeners;
//use App\Events\TransactionSaved;
//use App\Models\Invoice;
//use Illuminate\Support\Facades\Log;
//class UpdateInvoice
//{
//    public function handle(TransactionSaved $event)
//    {
//        $transaction = $event->transaction;
//
//        // Логика обновления статуса события
//        $invoice = $transaction->invoice;
//
//        if ($transaction->status === 'success' and !$transaction->processing) {
//           // if ($transaction->type === 'debit') {
//                // $invoice->factical_amount += $transaction->amount;
//                //  if($invoice->status==='pending' or $invoice->status==='partially_paid') {
//                /* $facticalAmount = $invoice->transactions()
//                         ->where('status', 'success')
//                         ->where('type', 'debit')->sum('amount')
//                     - $invoice->transactions()
//                         ->where('status', 'success')
//                         ->where('type', 'refund')->sum('amount');
//
//                 $invoice->factical_amount = $facticalAmount;
//
//                 $invoice->status = $invoice->factical_amount >= $invoice->amount ? 'paid' : 'partially_paid';
//                 $invoice->save();
//
//         }*/
//                if ($transaction->type === 'debit') {
//                    // пересчёт суммы по всем транзакциям
//                   /* $facticalAmount = $invoice->transactions()
//                            ->where('status', 'success')
//                            ->where('type', 'debit')->sum('amount')
//                        - $invoice->transactions()
//                            ->where('status', 'success')
//                            ->where('type', 'refund')->sum('amount');
//
//                    $remaining = $transaction->amount;*/
//
//                    // 1. закрываем текущий инвойс
//                   /* if ($invoice->status === 'pending' || $invoice->status === 'partially_paid') {
//                        $invoiceRemaining = $invoice->amount - $invoice->factical_amount;
//
//                        if ($remaining >= $invoiceRemaining) {
//                            // закрываем полностью
//                            $invoice->factical_amount = $invoice->amount;
//                            $invoice->status = 'paid';
//                            $remaining -= $invoiceRemaining;
//                        } elseif ($remaining > 0) {
//                            // частично покрываем остаток
//                            $invoice->factical_amount += $remaining;
//                            $invoice->status = 'partially_paid';
//                            $remaining = 0;
//                        }
//
//                        $invoice->save();
//                    }*/
//                    //$remaining = $transaction->amount;
//
//// 1. Пересчёт текущего инвойса по сумме транзакций
//
//                    //Работа с дебетовой транзакцией
//                    $facticalAmount = $invoice->transactions()
//                            ->where('status', 'success')
//                            ->where('type', 'debit')->sum('amount')
//                        - $invoice->transactions()
//                            ->where('status', 'success')
//                            ->where('type', 'refund')->sum('amount');
//                    $remaining=0;
//                 // ограничиваем фактическую сумму максимумом
//                   // $invoice->factical_amount = min($facticalAmount, $invoice->amount);
//
//                    //обновление текущего инвойса
//                    if ($facticalAmount >= $invoice->amount) {
//                        $invoice->status = 'paid';
//                        $remaining = $facticalAmount-$invoice->amount;/*($invoice->amount - ($facticalAmount - $transaction->amount))*/;
//                        $invoice->factical_amount = $invoice->amount;
//                        // уменьшаем остаток транзакции на ту часть, что пошла в текущий инвойс
//                    } elseif ($invoice->factical_amount > 0) {
//                        $invoice->status = 'partially_paid';
//                        $invoice->factical_amount = $facticalAmount;
//                        $remaining = 0; // всё ушло в текущий
//                    } else {
//                        $invoice->status = 'pending';
//                    }
//
//                    $invoice->save();
//                    Log::info('Остаток сверхоплаты: '.$remaining);
//
//                    // 2. закрываем долги
//                    if ($remaining > 0) {
//                        $debts = Invoice::where('client_id', $invoice->client_id)
//                            ->whereIn('status', ['pending', 'partially_paid'])
//                            ->where('id', '!=', $invoice->id)
//                            ->where('subscription_id', $invoice->subscription_id)
//                            ->orderBy('created_at')
//                            ->get();
//
//                        foreach ($debts as $debt) { //долги
//                            $debtRemaining = $debt->amount - $debt->factical_amount; //узнаем сколько не хватает для покрытия долга
//                           // $debt->factical_amount = min($debt->factical_amount + $remaining, $debt->amount);
//
//                            if ($remaining >= $debtRemaining) {
//                                // закрываем полностью
//                                $debt->factical_amount = $debt->amount;
//                                //$debt->factical_amount = min($debt->factical_amount + $remaining, $debt->amount);
//                                $debt->status = 'paid';
//                                $remaining -= $debtRemaining;
//                            } elseif ($remaining > 0) {
//                                // частично покрываем остаток
//                               // $debt->factical_amount += $remaining;
//                                $debt->factical_amount = min($debt->factical_amount + $remaining, $debt->amount);
//                                $debt->status = 'partially_paid';
//                                $remaining = 0;
//                                break;
//                            }
//
//                            $debt->save();
//                        }
//                    }
//
//                    // 3. создаём новые инвойсы
//                    if ($remaining > 0) {
//
//                        $price = $invoice->subscription->price;
//                        $start = \Carbon\Carbon::parse($invoice->subscription->end_date);
//                        $numberInvoices = ceil($remaining/$price);
//
//                        for($i = 0; $i < $numberInvoices; $i++) {
//                            $amountForThis = min($remaining, $price);
//
//
//                            Invoice::create([
//                                'client_id' => $invoice->client_id,
//                                'subscription_id' => $invoice->subscription_id,
//                                'amount' => $price,
//                                'factical_amount' => $amountForThis,
//                                'status' => $amountForThis < $price ? 'partially_paid' : 'pending',
//                                'billing_period_start' => $start,
//                                'billing_period_end' => $start->copy()->addMonth(),
//                                'currency' => $invoice->currency,
//                            ]);
//
//                            $remaining -= $amountForThis;
//                            $start = $start->copy()->addMonth();
//                            Log::info('Сверхоплатой закрываем будущие инвойсы: '.$remaining);
//                        }
//                    }
//                }
//
//
//                if ($transaction->type === 'refund') {
//                    if ($invoice->factical_amount <= 0) {
//                        throw new \Exception("Нельзя вернуть средства: баланс подписки равен 0");
//                    }
//                    $invoice->factical_amount -= $transaction->amount;
//                    $invoice->status = $invoice->factical_amount <= 0 ? 'refunded' : 'partially_refunded';
//                    $invoice->save();
//                }
//
//            }
//            /* if ($subscription && $subscription->invoices()->sum('factical_amount') >= $subscription->price) {
//                 $subscription->update(['status' => 'paid']);
//             }*/
//        $transaction->processing=true;
//        $transaction->saveQuietly();
//        }
//   // }
//}
//






//namespace App\Listeners;
//
//use App\Events\TransactionSaved;
//use App\Models\Invoice;
//use Illuminate\Support\Facades\Log;
//use Carbon\Carbon;
//
//class UpdateInvoice
//{
//    public function handle(TransactionSaved $event)
//    {
//        $transaction = $event->transaction;
//        $invoice = $transaction->invoice;
//
//        if ($transaction->status === 'success' && !$transaction->processing) {
//
//            // Работа с дебетовой транзакцией
//            if ($transaction->type === 'debit') {
//                $remaining = $transaction->amount; // остаток именно этой транзакции
//
//                // 1. закрываем текущий инвойс
//                $invoiceRemaining = $invoice->amount - $invoice->factical_amount;
//
//                if ($remaining >= $invoiceRemaining) {
//                    // закрываем полностью
//                    $invoice->factical_amount = $invoice->amount;
//                    $invoice->status = 'paid';
//                    $remaining -= $invoiceRemaining;
//                } else {
//                    // частично покрываем
//                    $invoice->factical_amount += $remaining;
//                    $invoice->status = 'partially_paid';
//                    $remaining = 0;
//                }
//
//                $invoice->save();
//                Log::info('Остаток сверхоплаты после текущего инвойса: ' . $remaining);
//
//                // 2. закрываем долги
//                if ($remaining > 0) {
//                    $debts = Invoice::where('client_id', $invoice->client_id)
//                        ->whereIn('status', ['pending', 'partially_paid'])
//                        ->where('id', '!=', $invoice->id)
//                        ->where('subscription_id', $invoice->subscription_id)
//                        ->orderBy('created_at')
//                        ->get();
//
//                    foreach ($debts as $debt) {
//                        $debtRemaining = $debt->amount - $debt->factical_amount;
//
//                        if ($remaining >= $debtRemaining) {
//                            // закрываем полностью
//                            $debt->factical_amount = $debt->amount;
//                            $debt->status = 'paid';
//                            $remaining -= $debtRemaining;
//                        } elseif ($remaining > 0) {
//                            // частично покрываем
//                            $debt->factical_amount += $remaining;
//                            $debt->status = 'partially_paid';
//                            $remaining = 0;
//                            break;
//                        }
//
//                        $debt->save();
//                    }
//                }
//
//                // 3. создаём новые инвойсы (будущие периоды)
//                if ($remaining > 0) {
//                    $price = $invoice->subscription->price;
//                    $start = Carbon::parse($invoice->subscription->end_date);
//                    $numberInvoices = ceil($remaining / $price);
//
//                    for ($i = 0; $i < $numberInvoices; $i++) {
//                        $amountForThis = min($remaining, $price);
//
//                        Invoice::create([
//                            'client_id' => $invoice->client_id,
//                            'subscription_id' => $invoice->subscription_id,
//                            'amount' => $price,
//                            'factical_amount' => $amountForThis,
//                            'status' => $amountForThis < $price ? 'partially_paid' : 'pending',
//                            'billing_period_start' => $start,
//                            'billing_period_end' => $start->copy()->addMonth(),
//                            'currency' => $invoice->currency,
//                        ]);
//
//                        $remaining -= $amountForThis;
//                        $start = $start->copy()->addMonth();
//                        Log::info('Сверхоплатой закрываем будущие инвойсы, остаток: ' . $remaining);
//                    }
//                }
//            }
//
//            // Работа с возвратами
//            if ($transaction->type === 'refund') {
//                if ($invoice->factical_amount <= 0) {
//                    throw new \Exception("Нельзя вернуть средства: баланс подписки равен 0");
//                }
//                $invoice->factical_amount -= $transaction->amount;
//                $invoice->status = $invoice->factical_amount <= 0 ? 'refunded' : 'partially_refunded';
//                $invoice->save();
//            }
//
//            // Помечаем транзакцию как обработанную
//            $transaction->processing = true;
//            $transaction->saveQuietly();
//        }
//    }
//}
