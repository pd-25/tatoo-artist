<?php

namespace App\Http\Controllers\Admin\Sales;

use App\core\sales\SalesInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SalesController extends Controller
{
    private $salesInterface;

    public function __construct(SalesInterface $salesInterface)
    {
        $this->salesInterface = $salesInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['sales'] = $this->salesInterface->getAllSales();
        return view('admin.sales.index', $data);
    }

     /**
     * Display a listing of the customers.
     */
    public function customers()
    {
        $data['customers'] = User::where('type','=','Customer')->get();
        return view('admin.customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'numeric',
        ]);
        $data = $request->only('name', 'username', 'email', 'phone', 'password', 'profile_image');
        $store = $this->salesInterface->storeSalesData($data);
        if ($store) {
            return redirect()->route('sales.index')->with('msg', 'New sales added successfully.');
        } else {
            return back()->with('msg', 'Some error occur.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['sales'] = $this->salesInterface->getSingleSales(decrypt($id));
        if ($data['sales'] == 'Not Found') {
            return back()->with('msg', 'No sales found!');
        }
        return view('admin.sales.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['sales'] = $this->salesInterface->getSingleSales(decrypt($id));
        // dd($data);
        if ($data['sales'] == 'Not Found') {
            return back()->with('msg', 'No sales found!');
        }
        return view('admin.sales.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'numeric',
        ]);

        $data = $request->only('name', 'username', 'email', 'phone', 'password', 'profile_image');

        $update = $this->salesInterface->updateSales($data, decrypt($id));
       
        if ($update) {
            return back()->with('msg', 'Sales information updated successfully.');
        } elseif ($update == 'No data') {
            return back()->with('msg', 'No sales found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->salesInterface->deleteSales(decrypt($id));
        if ($delete) {
            return back()->with('msg', 'Sales has been deleted successfully with his all artworks .');
        } elseif ($delete == 'No data') {
            return back()->with('msg', 'No artwork found.');
        }
    }
}
