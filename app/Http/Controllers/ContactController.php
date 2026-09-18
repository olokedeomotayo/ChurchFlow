<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a new contact enquiry.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'church_name' => [
                'required',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'subject' => [
                'required',
                'string',
                'in:demo,pricing,support,other',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        Contact::create([
            'name' => $validated['name'],
            'church_name' => $validated['church_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);


        return back()->with(
            'contact_success',
            'Thank you for contacting ChurchFlow. We will get back to you shortly.'
        );
    }
}