<?php

namespace App\Http\Controllers\Users;

use App\Globals\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Services\Users\UsersService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    protected UsersService $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = $this->userService->index();
            return response($users, HttpStatusCodes::OK)
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
                'name' => "required",
                'email' => "required",
                'password' => "required",
                'roles' => "required"
            ]);
            DB::beginTransaction();
            $user = $this->userService->store($request->all());
            DB::commit();
            return response($user, HttpStatusCodes::CREATED)
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
            $user = $this->userService->findBy($id);
            if(empty($user)){
                return response("User doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            return response($user, HttpStatusCodes::INTERNAL_SERVER_ERROR)
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
            $user = $this->userService->findBy($id);
            if(empty($user)){
                return response("User doesn't found.", HttpStatusCodes::NOT_FOUND)
                    ->header("Content-Type", "application/json");
            }
            $user->update($request->all());
            return response($user, HttpStatusCodes::OK)
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
            $user = $this->userService->destroy($id);
            if(empty($user)){
                return response("User doesn't found.", HttpStatusCodes::NOT_FOUND)
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
