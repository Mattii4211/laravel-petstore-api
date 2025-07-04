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

        <label for="name">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>


        <label for="category_name">Category name</label>
        <input type="text" name="category" value="{{ old('category') }}" required>

        <label for="photoUrls[]">Photo links</label>
        <textarea name="photoUrls[]" placeholder="One link one line">{{ old('photoUrls.0') }}</textarea>

        <label for="tags">Tags</label>
        <div id="tags">
            <div class="tag-group">
                <input type="text" name="tags[0][name]" placeholder="Tag name" value="{{ old('tags.0.name') }}">
            </div>
        </div>

        <label for="status">Status</label>
        <select name="status">
            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
        </select>

        <button type="submit" class="submit-btn">Save</button>
    </form>
</body>
</html>