<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use App\Services\Cards\CardsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CardsController extends Controller{

    protected CardsService $cardService;

    public function __construct(CardsService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $cards = $this->cardService->index();
            return response($cards, 200)
            ->header("Content-Type", "application/json");;
        }catch(Exception $e){
            return response($e->getMessage(), 400)
                    ->header("Content-Type", "application/json");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                "title" => "required", 
                "idiom" => "required", 
                "definition" => "required",
                "id_list" => "required"
            ]);
            DB::beginTransaction();
            $card = $this->cardService->store($request->all());
            DB::commit();
            return response($card, 201)
                    ->header("Content-Type", "application/json");
        }catch(ValidationException $v){
            DB::rollBack();
            return response($v->errors(), 400)
                ->header("Content-Type", "application/json");
        }catch(Exception $e){
            DB::rollBack();
            return response($e->getMessage(), 400)
                    ->header("Content-Type", "application/json");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $card = $this->cardService->findBy($id);
            if(empty($card)){
                return response("Card doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            return response($card, 200)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), 400)
                    ->header("Content-Type", "application/json");
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $card = $this->cardService->findBy($id);
            if(empty($card)){
                return response("Card doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            $card->update($request->all());
            return response($card, 200)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), 400)
                    ->header("Content-Type", "application/json");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = $this->cardService->destroy($id);
            if(empty($card)){
                return response("Card doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            $card->delete();
            return response(null, 204)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), 400)
                ->header("Content-Type", "application/json");
        }
    }
}
