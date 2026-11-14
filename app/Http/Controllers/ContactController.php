<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function submit(StoreContactRequest $request)
    {
        $validated = $request->validated();
        $productId = $validated['product_id'] ?? null;

        if ($productId !== null) {
            $product = Product::findOrFail($productId);

            ServiceRequest::create([
                'user_id' => $request->user()->getAuthIdentifier(),
                'product_id' => $product->getKey(),
                'sender_name' => $request->user()->name,
                'sender_email' => $request->user()->email,
                'sender_phone' => $validated['sender_phone'],
                'message' => $validated['message'] ?? null,
                'status' => ServiceRequest::STATUS_WAITING,
            ]);

            return to_route('contact')->with('success', 'Permintaan layanan berhasil dikirim.');
        }

        Contact::create([
            'user_id' => $request->user()->getAuthIdentifier(),
            'sender_name' => $request->user()->name,
            'sender_email' => $request->user()->email,
            'sender_phone' => $validated['sender_phone'] ?? null,
            'product_id' => null,
            'message' => $validated['message'] ?? null,
        ]);

        return to_route('contact')->with('success', 'Pesan berhasil dikirim. Tim kami akan menghubungi Anda.');
    }
}
