@extends('layouts.app')

@section('title', 'Dashboard Ketua UKM')

@section('content')
@include('homepage.partials.hero')
@include('homepage.partials.bem')
@include('homepage.partials.ukm')
@include('homepage.partials.activities')
@endsection
