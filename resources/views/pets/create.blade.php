<!DOCTYPE html>
<html>
<head><title>Add Pet</title></head>
<body>
<h1>Add a New Pet</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="/pets">
    @csrf
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Status: <input type="text" name="status" required></label><br>
    <button type="submit">Add</button>
</form>
</body>
</html>