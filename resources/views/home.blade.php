@extends('layouts.app')

@section('title', 'TKDS Media - Your World, Live and Direct')
@section('meta_description', 'Leading digital broadcasting solutions with professional streaming, cloud production, and OTT platforms. Transform your content with TKDS Media.')

@section('content')
    @include('components.hero-section')
  
    @include('components.broadcast-showcase')
       @include('components.video-showcase')
        @include('components.pricing-section')
    @include('components.services-section')
    @include('components.clients-section')
    @include('components.roku-highlight-section')

    @include('components.products-section')
    @include('components.live-stats-section')
    @include('components.team-section')
   
    @include('components.blog-section')  

@endsection