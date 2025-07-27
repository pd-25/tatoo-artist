<?php

namespace App\Http\Controllers\Customers;

use App\core\customers\TattoQuoteInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use App\Helper\UserHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class TattoQuoteController extends Controller
{
    private $tattoQuoteInterface;
    public function __construct(TattoQuoteInterface $tattoQuoteInterface)
    {
        $this->tattoQuoteInterface = $tattoQuoteInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $artists = User::where('type', 'artist')->get();
        return view('customers.tatto-quote-form', compact('artists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        // $validator = Validator::make($request->all(), [
        //     'color'  => 'required',
        //     'size' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 422,
        //         'errors' => $validator->errors(),
        //     ]);
        // }
// dd($request->all());

        $data = $request->only('color','size','description','artist_id','when_get_tattooed','reference_image','budget','availability','front_back_view');
        $data['user_id'] = auth()->guard('customers')->id();
        // echo '<pre>'; print_r($data); echo '</pre>';
        // exit;
        // dd($data); 
        $store = $this->tattoQuoteInterface->storeTattoQuoteData($data);
        if ($store) {
            return response()->json([
                'flag' => 1,
                'status' => 200,
                'msg' => 'Your Quote request is saved and sent.'
                
            ]);
            //return redirect()->route('tatto-quotes.create')->with('msg', 'Your Quote request is save and sent.');
        } else {
            return back()->with('msg', 'Some error occur.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeReferenceImage(Request $request){

        // if (isset($data['reference_image']) && $data['reference_image'] != null) {
        //     $content_db = time() . rand(0000, 9999) . "." . $data['reference_image']->getClientOriginalExtension();
        //     $data['reference_image']->storeAs("public/quoteImage", $content_db);
        //     $data['reference_image'] = $content_db;
        // }else{
        //     $data['reference_image'] = '';
        // }
        
        $imageName = time(). rand(0000, 9999) .'.'.$request->reference_image->extension();  
        $request->reference_image->storeAs('public/quoteImage', $imageName);
        $result['imagename'] = $imageName;
        $result['message'] = 'Successfully Uploaded';
        return response()->json($result);
        
        
    }
}
