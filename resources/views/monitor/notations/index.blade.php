@extends('layouts.app')

@section('content')
    @include ('monitor.partials.city-header', ['category' => 'notations']) {{-- Page-header --}}

    <div class="container py-3">
        <div class="row">
            @include('monitor.partials.show-sidenav') {{-- Shared sidenav partial --}}

            <div class="col-md-9"> {{-- Content field --}}
                <div class="card card-body">
                    <h6 class="border-bottom border-gray pb-2 mb-0">
                        City notations
                        
                        <a href="" class="small no-underline float-right">
                            <i class="fe fe-plus-circle mr-1"></i> Create notation
                        </a>
                    </h6>

                    {{-- @todo Implement table --}}
                </div>
            </div> {{-- /// Content field --}}
        </div>
    </div>
@endsection