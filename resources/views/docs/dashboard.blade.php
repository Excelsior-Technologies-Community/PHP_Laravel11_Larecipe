<!DOCTYPE html>
<html>
<head>
    <title>Documentation Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f8f9fa; }
        h2 { margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #222;
            color: white;
        }
        tr:hover { background: #f1f1f1; }
        .card {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h2>📊 Documentation Analytics Dashboard</h2>

<div class="card">
    <strong>Total Pages Tracked:</strong> {{ $data->count() }}
</div>

<h3>📄 Page Views & Feedback</h3>

<table>
    <thead>
        <tr>
            <th>Version</th>
            <th>Page</th>
            <th>Views</th>
            <th>👍 Likes</th>
            <th>👎 Dislikes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->version }}</td>
            <td>{{ $row->page }}</td>
            <td>{{ $row->views }}</td>
            <td>{{ $row->likes ?? 0 }}</td>
            <td>{{ $row->dislikes ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>🔍 Search History</h3>

<table>
    <thead>
        <tr>
            <th>Search Query</th>
            <th>IP Address</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($searches as $search)
        <tr>
            <td>{{ $search->query }}</td>
            <td>{{ $search->ip_address }}</td>
            <td>{{ $search->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>