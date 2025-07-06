<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(ContactRequest $request)
    {
        $validated = $request->validated();

        Mail::to('admin@example.com')->send(new ContactMessage($validated));

        return response()->json(['message' => 'Message sent successfully!']);
    }
}
