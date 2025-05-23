@extends('layout')

@section('title')
会員登録
@endsection

@section('contents')
<h1>ユーザ登録</h1>

        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif

        <form action="/user/register" method="post">
            @csrf
            名前:<input type="text" name="name" value="{{ old('name') }}"><br>
            email:<input type="email" name="email" value="{{ old('email') }}"><br>
            パスワード:<input type="password" name="password"><br>
            <button>登録する</button>
        </form>
@endsection