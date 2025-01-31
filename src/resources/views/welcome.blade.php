@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="">
    <div class="login__link">
    <a class="login__button-submit" href="/admin">管理画面へ</a>
  </div>
  <div class="login__link">
    <a class="login__button-submit" href="/contact">お問い合わせフォームへ</a>
  </div>
</div>
@endsection
