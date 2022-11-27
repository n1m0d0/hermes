<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClient;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('status', Client::Active)->get();

        return ClientCollection::make($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $user = new User();
        $user->name = $request->name . " " . $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->assignRole('client');

        $client = new Client();
        $client->user_id = $user->id;
        $client->country_id = $request->country_id;
        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->identification_card = $request->identification_card;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->save();

        return ClientResource::make($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return ClientResource::make($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
