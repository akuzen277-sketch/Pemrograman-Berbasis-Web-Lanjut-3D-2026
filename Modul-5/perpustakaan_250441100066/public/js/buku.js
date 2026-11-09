const API_URL = '/api/buku';

document.addEventListener('DOMContentLoaded', () => {
    fetchBuku();

    const bukuForm = document.getElementById('buku-form');
    if (bukuForm) {
        bukuForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const id = document.getElementById('buku_id').value;
            const payload = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: document.getElementById('tahun_terbit').value
            };

            const isEdit = id !== '';
            const url = isEdit ? `${API_URL}/${id}` : API_URL;
            const method = isEdit ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (!res.ok) {
                    let errorMsg = data.message || 'Gagal menyimpan data.';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors).flat().join('<br>');
                    }
                    throw new Error(errorMsg);
                }

                showAlert(isEdit ? 'Data buku berhasil diperbarui!' : 'Buku baru berhasil ditambahkan!', 'success');
                resetForm();
                fetchBuku(); // Perbarui tabel tanpa reload halaman
            } catch (err) {
                showAlert(err.message, 'danger');
            }
        });
    }
});

// 1. GET: Ambil Data dari API Resource menggunakan async/await
async function fetchBuku() {
    try {
        const res = await fetch(API_URL, {
            headers: { 'Accept': 'application/json' }
        });

        if (!res.ok) throw new Error('Gagal mengambil data dari API.');

        const responseData = await res.json();
        const books = responseData.data || responseData;

        const tbody = document.getElementById('buku-table-body');
        tbody.innerHTML = '';

        if (books.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" align="center">Tidak ada data buku.</td></tr>';
            return;
        }

        const permissions = window.bukuPermissions || {};

        books.forEach(buku => {
            let tombolAksi = '';

            if (permissions.edit) {
                tombolAksi += `
                    <button onclick="editBuku(
                        ${buku.id},
                        ${buku.kategori_id},
                        '${buku.judul}',
                        '${buku.penulis}',
                        ${buku.tahun_terbit}
                    )" class="btn-edit">Ubah</button>
                `;
            }

            if (permissions.delete) {
                tombolAksi += `
                    <button onclick="deleteBuku(${buku.id})"
                        class="btn-delete">Hapus</button>
                `;
            }

            tbody.innerHTML += `
                <tr>
                    <td>${buku.kategori || '-'}</td>
                    <td>${buku.judul}</td>
                    <td>${buku.penulis}</td>
                    <td>${buku.tahun_terbit}</td>
                    <td>${tombolAksi || '-'}</td>
                </tr>
            `;
        });
    } catch (err) {
        showAlert(err.message, 'danger');
    }
}

// Mengisi Form saat Tombol Ubah Diklik
function editBuku(id, kategori_id, judul, penulis, tahun_terbit) {
    const formTitle = document.getElementById('form-title');
    const btnCancel = document.getElementById('btn-cancel');
    const bukuId = document.getElementById('buku_id');

    if (!bukuId) return;

    bukuId.value = id;
    document.getElementById('kategori_id').value = kategori_id;
    document.getElementById('judul').value = judul;
    document.getElementById('penulis').value = penulis;
    document.getElementById('tahun_terbit').value = tahun_terbit;

    if (formTitle) formTitle.innerText = 'Ubah Data Buku';
    if (btnCancel) btnCancel.style.display = 'inline';
}

function resetForm() {
    const form = document.getElementById('buku-form');
    if (!form) return;

    form.reset();
    document.getElementById('buku_id').value = '';
    const formTitle = document.getElementById('form-title');
    const btnCancel = document.getElementById('btn-cancel');

    if (formTitle) formTitle.innerText = 'Tambah Buku Baru';
    if (btnCancel) btnCancel.style.display = 'none';
}

// 4. DELETE: Hapus Data Buku dengan Konfirmasi
async function deleteBuku(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) return;

    try {
        const res = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        });

        if (!res.ok) throw new Error('Gagal menghapus data buku.');

        showAlert('Buku berhasil dihapus.', 'success');
        fetchBuku(); // Perbarui tabel tanpa reload halaman
    } catch (err) {
        showAlert(err.message, 'danger');
    }
}

// 5. Penanganan Pesan Error / Sukses
function showAlert(message, type) {
    const container = document.getElementById('alert-container');
    if (!container) return;

    const bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
    const textColor = type === 'success' ? '#155724' : '#721c24';

    container.innerHTML = `
        <div style="padding: 10px; background-color: ${bgColor}; color: ${textColor}; margin-bottom: 15px; border-radius: 4px;">
            ${message}
        </div>
    `;

    setTimeout(() => {
        container.innerHTML = '';
    }, 4000);
}
