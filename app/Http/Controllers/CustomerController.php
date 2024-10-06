<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use domain\Facades\CustomerFacade;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerEditRequest;
use App\Http\Requests\CustomerCreateRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customers = CustomerFacade::all();

            return ApiResponse::success($customers);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerCreateRequest $request)
    {
        try {
            $customer = CustomerFacade::create($request->all());

            return ApiResponse::success($customer, 'Customer Created Successfully!');
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
            $customer = CustomerFacade::get($id);

            if (!$customer) {
                return ApiResponse::notFound();
            }

            return ApiResponse::success($customer);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerEditRequest $request, string $id)
    {
        try {

            $customer = CustomerFacade::get($id);

            if (!$customer) {
                return ApiResponse::notFound();
            }

            $customer = CustomerFacade::update($request->all(), $customer);

            return ApiResponse::success($customer, 'Customer Updated Successfully!');
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
            $customer = CustomerFacade::get($id);

            if (!$customer) {
                return ApiResponse::notFound();
            }

            $customer = CustomerFacade::destroy($customer);

            return ApiResponse::success($customer, 'Customer Deleted Successfully!');
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }
}
