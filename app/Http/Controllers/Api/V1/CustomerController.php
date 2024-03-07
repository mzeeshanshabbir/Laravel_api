<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use illuminate\http\Request;

class CustomerController extends Controller
{
    /**
      * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $filter_Items = $filter->transform($request);

        if(count($filter_Items) == 0) {
            return new  CustomerCollection(Customer::paginate());
        }else{
            return new CustomerCollection(Customer::where($filter_Items)->paginate());
        }




//        $filter = new CustomersFilter();
//        $filter_Items = $filter->transform($request);
//
//        $includeInvoices = $request->query('includeInvoices');
//
//        $customers = Customer::where($filter_Items);
//
//        if ($includeInvoices){
//            $customers = $customers->with('invoices');
//        }
//
//        return new CustomerCollection($customers->paginate()->appends($request->query()));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        if( $includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        return new CustomerResource($customer);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
