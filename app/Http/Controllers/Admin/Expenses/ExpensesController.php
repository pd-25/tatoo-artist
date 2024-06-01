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

    public function getExpenses(Request $request){
        if (Auth::guard('artists')->check()){
            $expense = ExpenseModel::where('user_id',Auth::guard('artists')->user()->id)->get();
        }else{
            $expense = ExpenseModel::with('user')->get();
        }
        return view('admin.expense.index',compact('expense'));
    }

    public function AddexpensesForm(Request $request){
        $data['artists'] = $this->artistInterface->getAllArtist();
        return view('admin.expense.create',$data);
    }

    public function formatDate($requestDate){
        $date = explode('/',$requestDate);
        $formattedDate = $date[2].'-'.$date[1].'-'.$date[0];
        return $formattedDate;
    }

    public function AddexpensesPost(Request $request){
        $this->validate($request, [
            'note'          => 'required',
            'expense_items'       => 'required',
        ],[
            'note.required' => 'Please enter note',
            'expense_items.required' => 'Please select expense',
        ]);

        // if(Auth::guard('artists')->check()){
        //     $userid = Auth::guard('artists')->user()->id;
        // }else{
        //     $userid = Auth::guard('admins')->user()->id;
        // }

        $emodel = new ExpenseModel();
        $emodel->user_id                                       = $request['user_id'];
        $emodel->transaction_date                              = $this->formatDate($request['transaction_date']);
        $emodel->payment_method                                = $request['payment_method'];
        $emodel->amount                                        = $request['amount'];
        $emodel->note                                          = $request['note'];
        $emodel->expense_items                                 = $request['expense_items'];
        $emodel->created_at                                    = date('Y-m-d h:i:s');
        
        $emodel->save();

        return redirect()->back()->with('message', 'Expense added successfully.');
    }

    public function editexpensesForm(Request $request,$id){
        $artists = $this->artistInterface->getAllArtist();
        $expenses = ExpenseModel::where('id',decrypt($id))->first();
        return view('admin.expense.edit',compact('expenses','artists'));
    }

    public function editexpensesPost(Request $request,$id){
        $this->validate($request, [
            'note'          => 'required',
            'expense_items'       => 'required',
        ],[
            'note.required' => 'Please enter note',
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
        $emodel->amount                                        = $request['amount'];
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
