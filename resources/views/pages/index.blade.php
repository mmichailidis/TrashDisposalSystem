@extends('main')
@section('title' , '| Καλώς Ήρθατε')
@section('content')
    <form action="" method="POST" id="form1">
        <label>Locations:</label>
        <input type="text" name="locations">
        <br>
        <label>Buckets:</label>
        <input type="text" name="buckets">
        <br>
        <label>Limitsof the road:</label>
        <input type="text" name="limits">
    </form>

    <form action="" method="POST" id="form2">
        <label>Capacity:</label>
        <input type="text" name="capacity">
        <br>
    </form>

    <form action="" method="POST" id="form3">
        <label>Input:</label>
        <input type="text" name="input">
        <br>
    </form>

    <form action="" method="POST" id="form4">
        <label>Changecable:</label>
        <input type="text" name="changecable">
        <br>
    </form>
@endsection