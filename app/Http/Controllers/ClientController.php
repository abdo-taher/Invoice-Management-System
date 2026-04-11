<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
        ]);

        Client::create($request->only([
            'full_name', 
            'address', 
            'representative_name', 
            'client_phone', 
            'representative_phone', 
            'tax_registration_number', 
            'email'
        ]));

        return redirect()->route('clients.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
        ]);

        $client->update($request->only([
            'full_name', 
            'address', 
            'representative_name', 
            'client_phone', 
            'representative_phone', 
            'tax_registration_number', 
            'email'
        ]));

        return redirect()->route('clients.index')->with('success', 'تم تعديل بيانات العميل بنجاح');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $clients = Client::where('full_name', 'like', "%$query%")->get();

        return view('clients.index', compact('clients'));
    }
}
