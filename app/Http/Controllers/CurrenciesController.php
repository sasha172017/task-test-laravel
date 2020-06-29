<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrenciesRequest;
use App\Models\Currencies;


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
            return response()->json(['message' => ['status'=>true, 'text' => 'Currency Created']], 201);
        } catch (\Exception $exception) {
            return response(['message' => ['status'=>false, 'text' => $exception->getMessage()]], 500);
        }
    }


    public function update(CurrenciesRequest $request, $id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $currencies = Currencies::find($id)->first();
            $oldBuy = $currencies->buy;
            $oldSell = $currencies->sell;
            $currencies->buy = floatval($data['buy']);
            $currencies->sell = floatval($data['sell']);
            $currencies->historyCurrencies()
                ->create([
                    'buy' => $oldBuy,
                    'sell' => $oldSell
                ]);
            $currencies->save();
            return response()->json(['message' => ['status'=>true, 'text' => 'Currency updated']], 200);
        } catch (\Exception $exception) {
            return response(['message' => ['status'=>false, 'text' => $exception->getMessage()]], 500);

        }
    }

    public function delete($id)
    {
        $currencies = Currencies::find($id)->first();
        $currencies->delete();
        return response()->json(['messageDelete' => 'Deleted'], 200);
    }

    public function history(){
        $currencies = Currencies::with('historyCurrencies')->get();
        return response()->json($currencies, 200);

    }
}
