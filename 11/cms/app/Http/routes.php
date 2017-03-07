<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/gstest', function () {
//     $a = ["1","2"];
//     Log::info($a);
//     return 'welcome GS!!';
// });

use App\Books;
use Illuminate\Http\Request;
/**
* 本のダッシュボード表示 */
Route::get('/', function () {
        $books = Books::orderBy('created_at', 'asc')->get(); 
        return view('books', [
        'books' => $books
    ]);
});
/**
* 新「本」を追加 */
        Route::post('/books ', function (Request $request) {
//バリデーション
        $validator = Validator::make($request->all(), [
        'item_name' => 'required|min:3|max:255',
        'item_amount' => 'required|digits_between:1,100000',
        'item_number' => 'required|digits_between:1,1000',
        'published' => 'required|date',
        
        
    ]);
//バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
// 本を作成処理... });
    $books = new Books;
    $books->item_name = $request->item_name; 
    $books->item_number = $request->item_number;
    $books->item_amount = $request->item_amount; 
    $books->published = $request->published;
    $books->save(); //「/」ルートにリダイレクト 
    return redirect('/');
});

/**
* 本を削除 */
Route::delete('/book/{book}', function (Books $book) {
    $book->delete();
    return redirect('/');
});

/**
* 本を更新 */
Route::get('/book/{book}/edit', function (Books $book) {
    $books = Books::orderBy('created_at', 'asc')->get(); 
    return view('books', [
    'book' => $book,
    'books' => $books
    ]);
});


Route::put('/book/{book}/edit', function (Request $request,Books $book) {
//バリデーション
        $validator = Validator::make($request->all(), [
        'item_name' => 'required|min:3|max:255',
        'item_amount' => 'required|digits_between:1,100000',
        'item_number' => 'required|digits_between:1,1000',
        'published' => 'required|date',
        
        
    ]);
//バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
// 本を作成処理... });
  
    $book->item_name = $request->item_name; 
    $book->item_number = $request->item_number;
    $book->item_amount = $request->item_amount; 
    $book->published = $request->published;
    $book->save(); //「/」ルートにリダイレクト 
    return redirect('/');
});