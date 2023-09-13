<?php

namespace App\Http\Controllers\Folders;

use App\Http\Controllers\Controller;
use App\Services\Folders\FoldersService;
use Illuminate\Http\Request;
use App\Services\Lists\ListsService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FoldersController extends Controller
{
    protected FoldersService $folderService;

    public function __construct(ListsService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $folders = $this->folderService->index();
            return response($folders, 200)
            ->header("Content-Type", "application/json");
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
                "id_user" => "required"
            ]);

            DB::beginTransaction();
            $folder = $this->folderService->store($request->all());
            DB::commit();
            return response($folder, 201)
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
            $list = $this->folderService->findBy($id);
            if(empty($list)){
                return response("Folder doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            return response($list, 200)
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
            $folder = $this->folderService->findBy($id);
            if(empty($folder)){
                return response("Folder doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            $folder->update($request->all());
            return response($folder, 200)
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
            $folder = $this->folderService->destroy($id);
            if(empty($folder)){
                return response("Folder doesn't found.", 404)
                    ->header("Content-Type", "application/json");
            }
            return response(null, 204)
                    ->header("Content-Type", "application/json");
        }catch(Exception $e){
            return response($e->getMessage(), 400)
                ->header("Content-Type", "application/json");
        }
    }
}
