@extends('layouts.report')

@section('title', 'Reporte de Usuarios')

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Ip</th>
                <th>Ultimo Login</th>
                <th>User agent</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($usuarios as $user)
            
                <tr>
                    <td>{{ $user->id }}</td>
                   <td>{{ $user->user->username }}</td>
                    <td>{{ $user->ip_address }}</td>
                    <td>{{ $user->logged_in_at }}</td>
                    <td>{{ $user->user_agent}}</td>


           
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
