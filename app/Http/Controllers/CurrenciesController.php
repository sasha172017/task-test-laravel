<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrenciesRequest;
use App\Models\Currencies;
use App\Models\HistoryCurrencies;
use App\Models\User;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class CurrenciesController extends Controller
{
    public function index()
    {
        return json_encode(Currencies::paginate(2)->jsonSerialize());
    }

    public function show($id)
    {
        return json_encode(Currencies::find($id)->jsonSerialize());
    }

    public function create(CurrenciesRequest $request)
    {
        try {
            $currencies = new Currencies();
            $currencies->currency = $request->currency;
            $currencies->buy = floatval($request->buy);
            $currencies->sell = floatval($request->sell);
            $currencies->save();
            return response()->json($currencies, 201);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }


    public function update(CurrenciesRequest $request, $id)
    {
        try {
            $currencies = Currencies::find($id)->first();
            $currencies->buy = floatval($request->buy);
            $currencies->sell = floatval($request->sell);
            $currencies->save();
            return response()->json($currencies, 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);

        }
    }

    public function delete($id)
    {
        $currencies = Currencies::find($id)->first();
        $currencies->delete();
        return response()->json(null, 204);
    }

    public function history(){
        $currencies = Currencies::with('historyCurrencies')->get();
        return response()->json($currencies, 200);

    }
}
