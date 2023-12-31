<?php

namespace App\Http\Controllers\Groups;

use App\Globals\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Services\Groups\GroupsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GroupsController extends Controller
{
    protected GroupsService $groupsService;

    public function __construct(GroupsService $groupsService)
    {
        $this->groupsService = $groupsService;
    }

    /**
     * Display a listing of the resource.
     *re
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $groups = $this->groupsService->index();
            return response($groups, HttpStatusCodes::OK)
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
                "title"   => "required",
                "users"   => "required"
            ]);
            DB::beginTransaction();
            $group = $this->groupsService->store($request->all());
            DB::commit();
            return response($group, HttpStatusCodes::CREATED)
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
            $group = $this->groupsService->findBy($id);
            if(empty($group)){
                return response("Group doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            return response($group, HttpStatusCodes::OK)
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
            $group = $this->groupsService->findBy($id);
            if(empty($folder)){
                return response("Group doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            $group->update($request->all());
            return response($group, HttpStatusCodes::OK)
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
            $group = $this->groupsService->destroy($id);
            if(empty($group)){
                return response("Group doesn't found.", HttpStatusCodes::NOT_FOUND)
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
