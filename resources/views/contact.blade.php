
@extends('layout')

@section('title', 'Contacto')

@section('header')
@parent
    <h2>Titulo que remplaza al heredado ( Cabecera) aparece por el parent</h2>
@stop


@section('content')
<h1>Contact</h1>
<p>This is contact</p>

@endsection('content')


