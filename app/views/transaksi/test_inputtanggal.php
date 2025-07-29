<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tanggal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tanggal", {
                dateFormat: "d/m/Y", // Format yang diinginkan
                allowInput: true ,// Memungkinkan input manual
                defaultDate: new Date()
            });
        });
    </script>
</head>
<body>
    <h1>Pilih Tanggal</h1>
    <form>
        <label for="tanggal">Tanggal (dd/mm/yyyy):</label>
        <input type="text" id="tanggal" name="tanggal" required>
        <br><br>
        <input type="submit" value="Kirim">
    </form>
</body>
</html>