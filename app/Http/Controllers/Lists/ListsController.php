<?php

namespace App\Http\Controllers\Lists;

use App\Globals\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Services\Lists\ListsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ListsController extends Controller
{
    protected ListsService $listsService;

    public function __construct(ListsService $listsService)
    {
        $this->listsService = $listsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $lists = $this->listsService->index();
            return response($lists, HttpStatusCodes::OK)
            ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
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
                "title" => "required"
            ]);

            DB::beginTransaction();
            $list = $this->listsService->store($request->all());
            DB::commit();
            return response($list, HttpStatusCodes::CREATED)
                    ->header("Content-Type", "application/json");
        }catch(ValidationException $v){
            DB::rollBack();
            return response($v->errors(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
                ->header("Content-Type", "application/json");
        }catch(Exception $e){
            DB::rollBack();
            return response($e->getMessage(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
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
            $list = $this->listsService->findBy($id);
            if(empty($list)){
                return response("List doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            return response($list, HttpStatusCodes::OK)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
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
            $list = $this->listsService->findBy($id);
            if(empty($list)){
                return response("List doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            $list->update($request->all());
            return response($list, HttpStatusCodes::OK)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
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
            $list = $this->listsService->destroy($id);
            if(empty($list)){
                return response("List doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            return response(null, HttpStatusCodes::NO_CONTENT)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), HttpStatusCodes::INTERNAL_SERVER_ERROR)
                ->header("Content-Type", "application/json");
        }
    }
}
