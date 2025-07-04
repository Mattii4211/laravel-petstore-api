<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Animals list</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #333;
        }

        a.button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .alert {
            color: red;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #eee;
        }

        .actions a, .actions form {
            display: inline-block;
            margin-right: 8px;
        }

        .actions form {
            margin: 0;
        }

        .actions button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <h1>Lista zwierząt</h1>

    <a href="/pets/create" class="button">Dodaj nowe zwierzę</a>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Zdjęcia</th>
                <th>Tagi</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pets as $pet)
                <tr>
                    <td>{{ $pet['id'] ?? 'brak' }}</td>
                    <td>{{ $pet['name'] ?? 'brak' }}</td>
                    <td>{{ $pet['category']['name'] ?? 'brak' }}</td>
                    <td>
                        @foreach ($pet['photoUrls'] ?? [] as $url)
                                @foreach ($pet['photoUrls'] ?? [] as $url)
                                    <img src="{{ $url }}" alt="Pet photo" style="max-width: 100px; max-height: 100px; margin: 4px;">
                                @endforeach
                        @endforeach
                    </td>
                    <td>
                        @foreach ($pet['tags'] ?? [] as $tag)
                            <span>{{ $tag['name'] ?? 'brak' }}</span><br>
                        @endforeach
                    </td>
                    <td>{{ $pet['status'] ?? 'brak' }}</td>
                    <td class="actions">
                        <a href="/pets/{{ $pet['id'] }}/edit" class="button" style="background-color: #2196F3;">Edytuj</a>

                        <form action="/pets/{{ $pet['id'] }}" method="POST" onsubmit="return confirm('Na pewno usunąć?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
