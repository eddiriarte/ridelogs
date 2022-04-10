@extends('_layouts.default')


@section('content')
    <h2>Hello, world!</h2>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Time</th>
            <th scope="col">Name</th>
            <th scope="col">Hospital</th>
            <th scope="col">Kilometers</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>10:12</td>
            <td>Mark Otto</td>
            <td>St. Louis Hospital</td>
            <td>5.23 km</td>
            <td></td>
        </tr>
        <tr>
            <td>10:17</td>
            <td>Jacob Thornton</td>
            <td>Sacred Heart Hospital</td>
            <td>9.12 km</td>
            <td></td>
        </tr>
        <tr>
            <td>10:32</td>
            <td>Jessica Blah</td>
            <td>Central Clinic</td>
            <td>8.42 km</td>
            <td></td>
        </tr>
        </tbody>
    </table>

@endsection
