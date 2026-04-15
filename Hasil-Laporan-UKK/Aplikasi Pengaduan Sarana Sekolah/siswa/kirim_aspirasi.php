<?php
// siswa/kirim_aspirasi.php
include '../layout/header.php';
include '../config/koneksi.php';
?>

<div class="container">
    <h2>Kirim Aspirasi</h2>
    <form action="../proses/simpan_aspirasi.php" method="POST">
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" name="nis" id="nis" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                // Ambil kategori dari database
                $result = mysqli_query($conn, "SELECT id_kategori, nama_kategori FROM kategori");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="aspirasi">Aspirasi</label>
            <textarea name="aspirasi" id="aspirasi" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>

<?php
include '../layout/footer.php';
?>
