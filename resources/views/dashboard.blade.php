@extends('layouts.app')

@section('content')
<Dashboard :user="{{auth()->user()}}" :permissions="{{auth()->user()->getPermissionsSlugs()}}" :roles="{{auth()->user()->getRolesSlugs()}}"></Dashboard>
@endsection