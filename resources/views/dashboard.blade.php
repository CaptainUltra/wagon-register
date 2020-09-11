@extends('layouts.app')

@section('head-scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endsection

@section('content')
<Dashboard :user="{{auth()->user()}}" :permissions="{{auth()->user()->getPermissionsSlugs()}}" :roles="{{auth()->user()->getRolesSlugs()}}"></Dashboard>
@endsection