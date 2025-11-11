<html>
<head>
    <title>Daftar Kategori</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
    <h1>Daftar Kategori</h1>
    <button onclick="openModal()">Tambah Kategori</button>
    
    <table border="1" style="border-color: red; margin-top: 20px;">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <tbody id="kategoriTable">
        </tbody>
    </table>

    <!-- Modal -->
    <div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;">
        <div style="background:white; margin:100px auto; padding:20px; width:400px; border-radius:5px;">
            <h2>Tambah Kategori</h2>
            <form id="formKategori">
                <label>Nama:</label><br>
                <input type="text" id="nama" required style="width:100%; padding:5px; margin-bottom:10px;"><br>
                
                <label>Deskripsi:</label><br>
                <textarea id="deskripsi" style="width:100%; padding:5px; margin-bottom:10px;"></textarea><br>
                
                <button type="button" onclick="submitKategori()">Simpan</button>
                <button type="button" onclick="closeModal()">Batal</button>
            </form>
        </div>
    </div>

    <script>
        // Load kategori on page load
        $(document).ready(function() {
            loadKategori();
        });

        function loadKategori() {
            $.get('/kategori-list', function(data) {
                let html = '';
                data.forEach((item, index) => {
                    html += '<tr>';
                    html += '<td>' + (index + 1) + '</td>';
                    html += '<td>' + item.nama + '</td>';
                    html += '<td>' + (item.deskripsi || '') + '</td>';
                    html += '<td><button onclick="deleteKategori(' + item.id + ')">Hapus</button></td>';
                    html += '</tr>';
                });
                $('#kategoriTable').html(html);
            });
        }

        function openModal() {
            $('#modal').show();
        }

        function closeModal() {
            $('#modal').hide();
            $('#formKategori')[0].reset();
        }

        function submitKategori() {
            let nama = $('#nama').val();
            let deskripsi = $('#deskripsi').val();

            $.ajax({
                url: '/kategori-store',
                method: 'POST',
                data: {
                    nama: nama,
                    deskripsi: deskripsi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    closeModal();
                    loadKategori();
                },
                error: function() {
                    alert('Error adding kategori');
                }
            });
        }

        function deleteKategori(id) {
            if(confirm('Hapus kategori ini?')) {
                $.ajax({
                    url: '/kategori-delete/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        loadKategori();
                    },
                    error: function() {
                        alert('Error deleting kategori');
                    }
                });
            }
        }
    </script>
</body>
</html>