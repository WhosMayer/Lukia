<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FinanceController extends Controller {
    public function register(Request $request) {
        $data=$request->validate(['name'=>'required|string|max:80','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:8|confirmed']);
        $user=DB::transaction(function() use ($data) {
            $user=User::create($data);
            foreach(['Salario','Alimentación','Transporte','Otros'] as $name) DB::table('categories')->insert(['user_id'=>$user->id,'name'=>$name,'created_at'=>now(),'updated_at'=>now()]);
            return $user;
        });
        Auth::login($user); $request->session()->regenerate(); return redirect('/panel');
    }
    public function login(Request $request) {
        $data=$request->validate(['email'=>'required|email','password'=>'required|string']);
        if(!Auth::attempt($data)) return back()->withErrors(['email'=>'El correo o la contraseña no son correctos.'])->onlyInput('email');
        $request->session()->regenerate(); return redirect('/panel');
    }
    public function logout(Request $request) {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect('/login');
    }
    public function index(Request $request) {
        $request->validate(['month'=>'nullable|date_format:Y-m']);
        $month=$request->input('month') ?: now()->format('Y-m');
        $start=\Carbon\Carbon::createFromFormat('!Y-m',$month);
        $query=DB::table('transactions')->where('transactions.user_id',Auth::id())->whereBetween('date',[$start->toDateString(),$start->copy()->endOfMonth()->toDateString()]);
        $income=(int)(clone $query)->where('type','income')->sum('amount_cents');
        $expense=(int)(clone $query)->where('type','expense')->sum('amount_cents');
        $transactions=$query->join('categories','category_id','=','categories.id')->select('transactions.*','categories.name as category')->orderByDesc('date')->orderByDesc('transactions.id')->paginate(10)->withQueryString();
        $categories=DB::table('categories')->where('user_id',Auth::id())->orderBy('name')->get();
        return view('panel',compact('month','income','expense','transactions','categories'));
    }
    private function data(Request $request): array {
        $data=$request->validate([
            'type'=>['required',Rule::in(['income','expense'])],
            'category_id'=>['required','integer',Rule::exists('categories','id')->where('user_id',Auth::id())],
            'amount'=>['required','regex:/^\d{1,9}(\.\d{1,2})?$/','numeric','min:0.01'],
            'date'=>'required|date_format:Y-m-d','description'=>'nullable|string|max:200',
        ]);
        [$whole,$fraction]=array_pad(explode('.',(string)$data['amount']),2,'');
        $data['amount_cents']=((int)$whole)*100+(int)str_pad($fraction,2,'0'); unset($data['amount']);
        $data['updated_at']=now(); return $data;
    }
    public function store(Request $request) {
        DB::table('transactions')->insert($this->data($request)+['user_id'=>Auth::id(),'created_at'=>now()]);
        return redirect('/panel?month='.substr($request->date,0,7))->with('status','Movimiento registrado.');
    }
    public function edit(int $id) {
        $transaction=DB::table('transactions')->where('user_id',Auth::id())->where('id',$id)->first(); abort_unless($transaction,404);
        $categories=DB::table('categories')->where('user_id',Auth::id())->orderBy('name')->get();
        return view('edit',compact('transaction','categories'));
    }
    public function update(Request $request,int $id) {
        $query=DB::table('transactions')->where('user_id',Auth::id())->where('id',$id); abort_unless((clone $query)->exists(),404);
        $query->update($this->data($request)); return redirect('/panel?month='.substr($request->date,0,7))->with('status','Movimiento actualizado.');
    }
    public function destroy(int $id) {
        $deleted=DB::table('transactions')->where('user_id',Auth::id())->where('id',$id)->delete(); abort_unless($deleted,404);
        return back()->with('status','Movimiento eliminado.');
    }
    public function category(Request $request) {
        $data=$request->validate(['name'=>['required','string','max:80',Rule::unique('categories')->where('user_id',Auth::id())]]);
        DB::table('categories')->insert($data+['user_id'=>Auth::id(),'created_at'=>now(),'updated_at'=>now()]);
        return back()->with('status','Categoría creada.');
    }
}
