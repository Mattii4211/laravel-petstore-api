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
    <label for="status">Status</label>
        <select name="status">
            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Dostępny</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Oczekuje</option>
            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sprzedany</option>
        </select>
    <label>Category: <input type="text" name="category" value="{{ $pet['category']['name'] ?? '-' }}"></label><br>
    <label for="photoUrls[]">Photo links</label>
    <textarea name="photoUrls[]" placeholder="One link one line">
        {{ implode("\n", old('photoUrls') ?? ($pet['photoUrls'] ?? [])) }}
    </textarea>
    <label for="tags">Tags</label>
    <div id="tags">
        <div class="tag-group">
            <input type="text" name="tags[0][name]" placeholder="Tag name" value="{{ old('tags.0.name') ?? $pet['tags'][0]['name'] ?? '' }}">
        </div>
    </div>
    <button type="submit">Update</button>
</form>
</body>
</html>