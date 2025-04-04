<?php

namespace App\Http\Controllers\Admin\Expenses;

use App\Http\Controllers\Controller;
use App\core\artist\ArtistInterface;
use Illuminate\Http\Request;
use App\Models\ExpenseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ExpensesController extends Controller
{
    private $artistInterface;

    public function __construct(ArtistInterface $artistInterface){
        $this->artistInterface = $artistInterface;
    }
    public function formatDate($requestDate){
        $date = explode('/',$requestDate);
        $formattedDate = $date[2].'-'.$date[0].'-'.$date[1];
        return $formattedDate;
    }
    public function printExpenses(Request $request)
{
    $query = ExpenseModel::with('user');

    // Check if start_date and end_date are provided in the request
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = $this->formatDate($request->start_date);
        $endDate = $this->formatDate($request->end_date);
    
        // Filter by transaction_date based on the start and end date
        $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
    
    // Filter by expense_items if not 'all'
    if ($request->filled('expense_items') && $request->expense_items != 'all') {
        $query->where('expense_items', $request->expense_items);
    }
    
    // If user is an artist, filter only their expenses
    if (Auth::guard('artists')->check()) {
        $query->where('user_id', Auth::guard('artists')->user()->id);
    }

    // Fetch the filtered or full list of expenses
    $expenses = $query->get();

    return view('admin.expense.printexpnce', compact('expenses'));
}


public function getExpenses(Request $request)
{
    $query = ExpenseModel::with('user');

    // Check if start_date and end_date are provided in the request
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = $this->formatDate($request->start_date);
        $endDate = $this->formatDate($request->end_date);
    
        // Filter by transaction_date based on the start and end date
        $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
    
    // Filter by expense_items if not 'all'
    if ($request->filled('expense_items') && $request->expense_items != 'all') {
        $query->where('expense_items', $request->expense_items);
    }

    // If user is an artist, filter only their expenses
    if (Auth::guard('artists')->check()) {
        $query->where('user_id', Auth::guard('artists')->user()->id);
    }

    // Fetch paginated expenses
    $expense = $query->where('isarchive',0)->orderBy('id','desc')->paginate(10); // Change 10 to the number of records per page

    return view('admin.expense.index', compact('expense'));
}

public function expansesArchiveMove(Request $request)
{
    $ids = $request->input('ids', []);

    if (empty($ids)) {
        return response()->json(['error' => 'No quotes selected.'], 400);
    }

    // Update the `isarchive` field to 1 for the given IDs
    ExpenseModel::whereIn('id', $ids)->update(['isarchive' => 1]);

    return response()->json(['success' => 'Quotes moved to archives!']);
}
public function getExpensesArchive(Request $request)
{
    $query = ExpenseModel::with('user');

    // Check if start_date and end_date are provided in the request
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = $this->formatDate($request->start_date);
        $endDate = $this->formatDate($request->end_date);
    
        // Filter by transaction_date based on the start and end date
        $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
    
    // Filter by expense_items if not 'all'
    if ($request->filled('expense_items') && $request->expense_items != 'all') {
        $query->where('expense_items', $request->expense_items);
    }

    // If user is an artist, filter only their expenses
    if (Auth::guard('artists')->check()) {
        $query->where('user_id', Auth::guard('artists')->user()->id);
    }

    // Fetch paginated expenses
    $expense = $query->where('isarchive',1)->orderBy('id','desc')->paginate(10); // Change 10 to the number of records per page

    return view('admin.expense.archives', compact('expense'));
}

    
    

    public function AddexpensesForm(Request $request){
        $data['artists'] = $this->artistInterface->getAllArtistss();
        return view('admin.expense.create',$data);
    }

 
    public function AddexpensesPost(Request $request){
        $this->validate($request, [
           
            'expense_items'       => 'required',
        ],[
            
            'expense_items.required' => 'Please select expense',
        ]);

        // if(Auth::guard('artists')->check()){
        //     $userid = Auth::guard('artists')->user()->id;
        // }else{
        //     $userid = Auth::guard('admins')->user()->id;
        // }
//   dd($request->all());
// dd($this->formatDate( $request['transaction_date']));
        $emodel = new ExpenseModel();
        $emodel->user_id                                       = $request['user_id'];
        $emodel->transaction_date                              = $this->formatDate( $request['transaction_date']);
        $emodel->payment_method                                = $request['payment_method'];
        $emodel->amount                                        = number_format((float)$request['amount'], 2, '.', '');

        $emodel->note                                          = $request['note'];
        $emodel->expense_items                                 = $request['expense_items'];
        $emodel->created_at                                    = date('Y-m-d h:i:s');
        
        $emodel->save();

        return redirect()->back()->with('message', 'Expense added successfully.');
    }

    public function editexpensesForm(Request $request,$id){
        $artists = $this->artistInterface->getAllArtistss();
        $expenses = ExpenseModel::where('id',decrypt($id))->first();
        return view('admin.expense.edit',compact('expenses','artists'));
    }

    public function editexpensesPost(Request $request,$id){
        $this->validate($request, [
           
            'expense_items'       => 'required',
        ],[
           
            'expense_items.required' => 'Please select expense',
        ]);

        // if(Auth::guard('artists')->check()){
        //     $userid = Auth::guard('artists')->user()->id;
        // }else{
        //     $userid = Auth::user()->id;
        // }

        $emodel = ExpenseModel::find(decrypt($id));
        $emodel->user_id                                       = $request['user_id'];;
        $emodel->transaction_date                              = $this->formatDate($request['transaction_date']);
        $emodel->payment_method                                = $request['payment_method'];
        $emodel->amount                                        = number_format((float)$request['amount'], 2, '.', '');

        $emodel->note                                          = $request->input('note');
        $emodel->expense_items                                 = $request->input('expense_items');
        $emodel->updated_at                                    = date('Y-m-d h:i:s');
        
        $emodel->save();

        return redirect()->back()->with('message', 'Expenses updated successfully.');


    }

    public function deleteexpensesForm(Request $request,$id){
        $emodel = ExpenseModel::find(decrypt($id));
        $emodel->delete();
        return back()->with('msg', 'Record deleted successfully.');
    }
}
