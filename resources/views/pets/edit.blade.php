<!DOCTYPE html>
<html>
<head><title>Edit Pet</title></head>
<body>
<h1>Edit Pet</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="/pets/{{ $pet['id'] }}">
    @csrf
    @method('PUT')
    <label>Name: <input type="text" name="name" value="{{ $pet['name'] ?? '-'}}" required></label><br>
    <label>Status: <input type="text" name="status" value="{{ $pet['status'] ?? '-'}}" required></label><br>
    <button type="submit">Update</button>
</form>
</body>
</html>