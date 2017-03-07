<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
<!-- Bootstrap の定形コード... -->
    <div class="panel-body">
<!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
<!-- バリデーションエラーの表示に使用-->
<!-- 本登録フォーム -->
@if(isset($book))
        <form action="{{ url('book/'.$book->id.'/edit') }}" method="POST" class="form-horizontal">
             {{ method_field('PUT') }}
            @else
            <form action="{{ url('books') }}" method="POST" class="form-horizontal">
            @endif
            {{ csrf_field() }}


<!-- 本のタイトル -->
            <div class="form-group">
                <label for="item_name" class="col-sm-3 control-label">Book</label>
                <div class="col-sm-6">
                    <input type="text" name="item_name" id="item_name" class="form-control" value="{{isset($book)?$book->item_name:old('item_name')}}">
                </div>
            </div>
<!-- 本の金額 -->
            <div class="form-group">
                <label for="item_amount" class="col-sm-3 control-label">金額</label>
                <div class="col-sm-6">
                    <input type="text" name="item_amount" id="item_amount" class="form-control" value="{{isset($book)?$book->item_amount:old('item_amount')}}">
                </div>
            </div>
<!-- 本の数 -->
            <div class="form-group">
                <label for="item_number" class="col-sm-3 control-label">数量</label>
                <div class="col-sm-6">
                    <input type="text" name="item_number" id="item_number" class="form-control" value="{{isset($book)?$book->item_number:old('item_number')}}">
                </div>
            </div>
<!-- 本の公開日 -->
            <div class="form-group">
                <label for="published" class="col-sm-3 control-label">公開日</label>
                <div class="col-sm-6">
                    <input type="date" name="published" id="published" class="form-control" value="{{isset($book)?date('Y-m-d',strtotime($book->published)):old('published')}}">
                </div>
            </div>

<!-- 本 登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i> Save
                    </button>
                </div>
            </div>
        </form>
        
        <!-- 現在の本 -->
@if (count($books) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
現在の本 </div>
<div class="panel-body">
                <table class="table table-striped task-table">
<!-- テーブルヘッダ --> 
<thead>
    <th>本一覧</th>
    <th>&nbsp;</th>
</thead>
<!-- テーブル本体 --> 
<tbody>
        @foreach ($books as $book)
    <tr>
    <!-- 本タイトル -->
        <td class="table-text">
            <div>{{ $book->item_name }}</div>
        </td>
    <!-- 本の金額 -->
        <td class="table-text">
            <div>{{ $book->item_amount }}</div>
        </td>
    <!-- 本の数 -->
        <td class="table-text">
            <div>{{ $book->item_number  }}</div>
        </td>
    <!-- 公開日 -->
        <td class="table-text">
            <div>{{ $book->published  }}</div>
        </td>

<!-- 本: 削除ボタン --> 
        <td>
            <form action="{{ url('book/'.$book->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger"> <i class="glyphicon glyphicon-trash"></i> 削除
                    </button>
            </form>
        </td> 
        <td>
            <form action="{{ url('book/'.$book->id.'/edit') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    <button type="submit" class="btn btn-danger"> <i class="glyphicon glyphicon-trash"></i> 更新
                    </button>
            </form>
        </td> 
    </tr>
            @endforeach
</tbody>
                </table>
            </div>
        </div>
    @endif
<!-- Book: 既に登録されてる本のリスト -->
        
        
        
        </div>
<!-- Book: 既に登録されてる本のリスト -->
@endsection
