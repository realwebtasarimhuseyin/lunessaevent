<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>FTP'ye Klasör Gönder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jstree@3.3.15/dist/themes/default/style.min.css" />


</head>

<body>
    <div class="container mt-4">
        <h3 class="mb-4">📤 Yerel Klasörü FTP'ye Gönder</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('ftp.upload') }}">
            @csrf
            <div class="row">
                <div class="col-12 mb-5">
                    <label>Gönderilecek Dosya ve Klasörleri Seç</label>
                    <div id="file-tree"></div>
                    <input type="hidden" name="selected_items" id="selected_items">
                </div>

                <div class="col-md-6">
                    <label for="ftp_path">FTP'de Hedef Klasör (boş bırakılırsa ana dizin)</label>
                    <select class="form-select" name="ftp_path" id="ftp_path">
                        <option value="">📂 Ana dizine gönder</option>
                        @foreach ($ftpFolders as $ftpFolder)
                            <option value="{{ $ftpFolder }}">{{ $ftpFolder }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Gönder</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jstree@3.3.15/dist/jstree.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#file-tree').jstree({
                'core': {
                    'check_callback': true,
                    'data': {
                        'url': '{{ route("ftp.klasor.agaci.detayli") }}',
                        'dataType': 'json',
                        'data': function (node) {
                            return { 'id': node.id };
                        }
                    },
                    'themes': {
                        'dots': true,
                        'icons': true
                    }
                },
                'checkbox': {
                    'keep_selected_style': false,
                    'three_state': false,
                    'cascade': 'undetermined' // alt klasör otomatik işaretlenmesin
                },
                'plugins': ['checkbox', 'types'],
                'types': {
                    'folder': { 'icon': 'jstree-folder' },
                    'file': { 'icon': 'jstree-file' }
                }
            });
        
            $('#file-tree').on('changed.jstree', function (e, data) {
                const selectedItems = data.selected;
                $('#selected_items').val(JSON.stringify(selectedItems));
            });
        });
        </script>
</body>

</html>
