@extends('frontend.layouts.app')
@section('title', 'Best Selling Products')
@section('content')
<section class="container py-5">
    <h1 class="mb-4">Best Selling Products</h1>
    @include('frontend.home.partials.product_list', ['products' => $bestsellers])
    <div class="mt-4">{{ $bestsellers->links() }}</div>
</section>
@endsection
