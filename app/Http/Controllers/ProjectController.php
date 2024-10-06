<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use domain\Facades\ProjectFacade;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectEditRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = ProjectFacade::all();

            return ApiResponse::success($projects);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectCreateRequest $request)
    {
        try {
            $project = ProjectFacade::create($request->all());

            return ApiResponse::success($project, 'Project Created Successfully!');
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $project = ProjectFacade::get($id);

            if (!$project) {
                return ApiResponse::notFound();
            }

            return ApiResponse::success($project);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectEditRequest $request, string $id)
    {
        try {

            $project = ProjectFacade::get($id);

            if (!$project) {
                return ApiResponse::notFound();
            }

            $project = ProjectFacade::update($request->all(), $project);

            return ApiResponse::success($project, 'Project Updated Successfully!');
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = ProjectFacade::get($id);

            if (!$project) {
                return ApiResponse::notFound();
            }

            $project = ProjectFacade::destroy($project);

            return ApiResponse::success($project, 'Project Deleted Successfully!');
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }
}
