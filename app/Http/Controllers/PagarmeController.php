<?php

namespace App\Http\Controllers;

use App\Models\Orders\Order;
use App\Models\User;
use App\Notifications\ConfirmationOrderCustomer;
use App\Notifications\FailedOrder;
use App\Notifications\OrderConfirmed;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PagarmeController extends Controller
{
    private function saveOrder($data, $status)
    {
        $pagarme_service = new PagarmeService();
        $order = $pagarme_service->orders()->get($data['data']['id']);
        $result['period'] = Order::where('pagarme_id', $data['data']['id'])->first();
        $result['period']->payment_status = $status;
        $result['period']->save();

        return collect(['order' => $order, 'period' => $result['period']]);
    }

    public function index(Request $request)
    {

        $data = $request->all();

        $webSocket = match ($data['data']['status']) {
            'paid' => OrderPaymentStatus::Paid->value,
            'failed' => OrderPaymentStatus::Failed->value,
            default => OrderPaymentStatus::Pending->value
        };

        if ($webSocket == OrderPaymentStatus::Paid->value) {
            $result = $this->saveOrder($data, OrderPaymentStatus::Paid->value);
            $mailCompany = User::where('userable_id', $result['period']->userCompany->partner_id)->get();
            $mailSend = User::where('email', $result['order']['customer']['email'])->get();
            Notification::send($mailCompany, new OrderConfirmed($data['data']['id'], $result['period']->id, $result['period']->company->slug));
            Notification::send($mailSend, new ConfirmationOrderCustomer($result['order'], $result['period']->period['value'], $result['period']->date, $result['order']['charges'][0]['payment_method']));
        }

        if ($webSocket == OrderPaymentStatus::Failed->value) {
            $result = $this->saveOrder($data, OrderPaymentStatus::Failed->value);
            $mailSend = User::where('email', $result['order']['customer']['email'])->get();
            Notification::send($mailSend, new FailedOrder());
        }

        return http_response_code(200);
    }
}
