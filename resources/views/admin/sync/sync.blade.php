<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Sync Google Sheets</title>
</head>

<body>
    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('admin.sync-sheet') }}" method="get">
        <button type="submit">Sincronizar Planilha</button>
    </form>
</body>

</html>
